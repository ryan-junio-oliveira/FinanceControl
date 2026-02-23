<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'force_password_change', 'role:root'])->prefix('admin')->group(function () {
    Route::get('settings', function () {
        return view('admin.settings');
    })->name('admin.settings');

    Route::resource('banks', \App\Modules\Admin\Presentation\Http\Controllers\BankController::class, [
        'as' => 'admin'
    ]);

    Route::resource('categories', \App\Modules\Admin\Presentation\Http\Controllers\CategoryController::class, [
        'as' => 'admin'
    ]);
});
