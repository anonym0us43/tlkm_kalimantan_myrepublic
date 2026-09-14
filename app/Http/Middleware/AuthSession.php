<?php

namespace App\Http\Middleware;

use App\Models\AuthModel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthSession
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check())
        {
            return redirect()->route('signin');
        }

        if (!session()->has('name'))
        {
            $profile = AuthModel::profile();

            session([
                'name' => $profile->nama,
                'role' => $profile->role_name,
                'area' => $profile->area_name,
            ]);
        }

        return $next($request);
    }
}
