<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\AreaModel;
use App\Models\EmployeeModel;
use App\Models\RoleModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    private const TELEGRAM_MESSAGES = [
        'chat_id.regex'           => 'Chat ID hanya boleh berisi angka (maksimal 19 digit).',
        'username_telegram.regex' => 'Username Telegram 5-32 karakter: huruf, angka, atau underscore.',
    ];

    public function index()
    {
        $areas = AreaModel::select('id', 'name')->orderBy('name')->get();
        $roles = RoleModel::select('id', 'name')->orderBy('name')->get();

        return view('administrator.employee', compact('areas', 'roles'));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'area_id'  => ['required', 'integer', 'exists:tb_area,id'],
            'role_id'  => ['required', 'integer', 'exists:tb_role,id'],
            'nik'      => ['required', 'string', 'max:12', 'unique:tb_employee,nik'],
            'nama'     => ['required', 'string', 'max:255'],
            'chat_id'  => ['nullable', 'regex:/^-?[0-9]{1,19}$/'],
            'username_telegram' => ['nullable', 'regex:/^[A-Za-z0-9_]{5,32}$/'],
            'status'   => ['required', 'boolean'],
            'password' => ['required', 'string', 'min:8'],
        ], self::TELEGRAM_MESSAGES);

        $validated['password']   = Hash::make($validated['password']);
        $validated['created_by'] = Auth::user()->nik;

        EmployeeModel::create($validated);

        return response()->json(['message' => 'Employee berhasil ditambahkan.']);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(
            EmployeeModel::select('id', 'area_id', 'role_id', 'nik', 'nama', 'chat_id', 'username_telegram', 'ip_address', 'status')->findOrFail($id)
        );
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $employee = EmployeeModel::findOrFail($id);

        $rules = [
            'area_id' => ['required', 'integer', 'exists:tb_area,id'],
            'role_id' => ['required', 'integer', 'exists:tb_role,id'],
            'nik'     => ['required', 'string', 'max:12', 'unique:tb_employee,nik,' . $id],
            'nama'    => ['required', 'string', 'max:255'],
            'chat_id' => ['nullable', 'regex:/^-?[0-9]{1,19}$/'],
            'username_telegram' => ['nullable', 'regex:/^[A-Za-z0-9_]{5,32}$/'],
            'status'  => ['required', 'boolean'],
        ];

        if ($request->filled('password'))
        {
            $rules['password'] = ['string', 'min:8'];
        }

        $validated = $request->validate($rules, self::TELEGRAM_MESSAGES);

        if ($request->filled('password'))
        {
            $validated['password'] = Hash::make($validated['password']);
        }
        else
        {
            unset($validated['password']);
        }

        $validated['updated_by'] = Auth::user()->nik;

        $employee->update($validated);

        return response()->json(['message' => 'Employee berhasil diperbarui.']);
    }

    public function destroy(int $id): JsonResponse
    {
        $employee = EmployeeModel::findOrFail($id);

        if ($employee->id === Auth::id())
        {
            return response()->json(['message' => 'Tidak dapat menghapus akun sendiri.'], 422);
        }

        $employee->delete();

        return response()->json(['message' => 'Employee berhasil dihapus.']);
    }
}
