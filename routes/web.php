<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CaptchaController;

Route::get('/captcha', [CaptchaController::class, 'generate'])
    ->name('captcha');

Route::middleware('guest')->group(function ()
{
    Route::get('/signin', [AuthController::class, 'showSignin'])
        ->name('signin');
    Route::post('/signin', [AuthController::class, 'signin'])
        ->name('signin.post');
    Route::get('/signup', [AuthController::class, 'showSignup'])
        ->name('signup');
    Route::post('/signup', [AuthController::class, 'signup'])
        ->name('signup.post');
});

Route::middleware('auth')->group(function ()
{
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [HomeController::class, 'index'])->name('home');
});
