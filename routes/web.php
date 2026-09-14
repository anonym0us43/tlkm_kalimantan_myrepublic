<?php

use App\Http\Middleware\AuthSession;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Administrator\AreaController;
use App\Http\Controllers\Administrator\RoleController;
use App\Http\Controllers\Administrator\EmployeeController;

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

Route::middleware(AuthSession::class)->group(function ()
{
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::prefix('ajax')->name('ajax.')->group(function ()
    {
        Route::get('/area/data',     [AjaxController::class, 'areaData'])->name('area.data');
        Route::get('/role/data',     [AjaxController::class, 'roleData'])->name('role.data');
        Route::get('/employee/data', [AjaxController::class, 'employeeData'])->name('employee.data');
    });

    Route::prefix('admin')->name('admin.')->group(function ()
    {
        Route::get('/area',         [AreaController::class, 'index'])->name('area.index');
        Route::post('/area',        [AreaController::class, 'store'])->name('area.store');
        Route::get('/area/{id}',    [AreaController::class, 'show'])->name('area.show');
        Route::put('/area/{id}',    [AreaController::class, 'update'])->name('area.update');
        Route::delete('/area/{id}', [AreaController::class, 'destroy'])->name('area.destroy');

        Route::get('/role',         [RoleController::class, 'index'])->name('role.index');
        Route::post('/role',        [RoleController::class, 'store'])->name('role.store');
        Route::get('/role/{id}',    [RoleController::class, 'show'])->name('role.show');
        Route::put('/role/{id}',    [RoleController::class, 'update'])->name('role.update');
        Route::delete('/role/{id}', [RoleController::class, 'destroy'])->name('role.destroy');

        Route::get('/employee',         [EmployeeController::class, 'index'])->name('employee.index');
        Route::post('/employee',        [EmployeeController::class, 'store'])->name('employee.store');
        Route::get('/employee/{id}',    [EmployeeController::class, 'show'])->name('employee.show');
        Route::put('/employee/{id}',    [EmployeeController::class, 'update'])->name('employee.update');
        Route::delete('/employee/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');
    });
});
