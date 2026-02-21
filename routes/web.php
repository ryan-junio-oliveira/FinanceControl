<?php

use App\Modules\Shared\Presentation\Http\Controllers\AuthController;
use App\Modules\Shared\Presentation\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/password/reset', function () {
    return view('auth.passwords.email');
})->name('password.request');

Route::post('/password/email', function () {
    return back()->with('status', 'Link enviado (placeholder)');
})->name('password.email');

Route::middleware('auth')->group(function () {
    Route::get('/password/change', [AuthController::class, 'showForceChangeForm'])->name('password.force');
    Route::post('/password/change', [AuthController::class, 'forceChangePassword'])->name('password.force.update');
});

Route::middleware(['auth', 'force_password_change'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/styleguide/palette', function () {
        return view('style.palette');
    })->name('style.palette');
});
