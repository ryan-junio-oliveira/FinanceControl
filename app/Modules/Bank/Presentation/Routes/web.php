<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Bank\Presentation\Http\Controllers\BankController;

Route::middleware(['web','auth','force_password_change'])->group(function () {
    Route::get('/banks', [BankController::class, 'index'])->name('banks.index');
});
