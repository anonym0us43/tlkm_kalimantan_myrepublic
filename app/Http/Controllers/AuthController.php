<?php

namespace App\Http\Controllers;

use App\Models\AuthModel;
use App\Models\RoleModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showSignin(): View
    {
        return view('auth.signin');
    }

    public function signin(Request $request): RedirectResponse
    {
        $request->validate([
            'nik'      => ['required', 'string', 'max:12'],
            'password' => ['required', 'string'],
            'captcha'  => ['required', 'string'],
        ]);

        if (strtolower($request->captcha) !== session('captcha_code'))
        {
            session()->forget('captcha_code');
            return back()->withErrors(['captcha' => 'Kode captcha tidak valid.'])->withInput();
        }

        session()->forget('captcha_code');

        if (!Auth::attempt(['nik' => $request->nik, 'password' => $request->password], $request->boolean('remember')))
        {
            return back()->withErrors(['nik' => 'NIK atau password salah.'])->withInput();
        }

        $request->session()->regenerate();

        Auth::user()->update(['ip_address' => $this->resolveIp()]);
        $this->storeSession();

        return redirect()->intended(route('home'));
    }

    public function showSignup(): View
    {
        $areas = DB::table('tb_area')->orderBy('name')->get(['id', 'name']);
        $roles = DB::table('tb_role')->where('id', '!=', RoleModel::ADMINISTRATOR_ID)->orderBy('name')->get(['id', 'name']);

        return view('auth.signup', compact('areas', 'roles'));
    }

    public function signup(Request $request): RedirectResponse
    {
        $request->validate([
            'nama'     => ['required', 'string', 'max:255'],
            'nik'      => ['required', 'string', 'max:12', 'unique:tb_employee,nik'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'area_id'  => ['required', 'integer', 'exists:tb_area,id'],
            'role_id'  => ['required', 'integer', 'exists:tb_role,id', Rule::notIn([RoleModel::ADMINISTRATOR_ID])],
            'captcha'  => ['required', 'string'],
        ]);

        if (strtolower($request->captcha) !== session('captcha_code'))
        {
            session()->forget('captcha_code');
            return back()->withErrors(['captcha' => 'Kode captcha tidak valid.'])->withInput();
        }

        session()->forget('captcha_code');

        $employee = AuthModel::create([
            'area_id'  => $request->area_id,
            'role_id'  => $request->role_id,
            'nama'     => $request->nama,
            'nik'      => $request->nik,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($employee);
        $request->session()->regenerate();
        $this->storeSession();

        return redirect()->route('home');
    }

    private function storeSession(): void
    {
        $profile = AuthModel::profile();

        session([
            'name'      => $profile->nama,
            'role'      => $profile->role_name,
            'area'      => $profile->area_name,
        ]);
    }

    private function resolveIp(): string
    {
        $ip_address = null;

        if (isset($_SERVER['HTTP_CLIENT_IP']))
        {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        elseif (isset($_SERVER['HTTP_X_FORWARDED']))
        {
            $ip_address = $_SERVER['HTTP_X_FORWARDED'];
        }
        elseif (isset($_SERVER['HTTP_FORWARDED_FOR']))
        {
            $ip_address = $_SERVER['HTTP_FORWARDED_FOR'];
        }
        elseif (isset($_SERVER['HTTP_FORWARDED']))
        {
            $ip_address = $_SERVER['HTTP_FORWARDED'];
        }
        elseif (isset($_SERVER['REMOTE_ADDR']))
        {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }
        else
        {
            $ip_address = 'UNKNOWN';
        }

        return $ip_address;
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('signin');
    }
}
