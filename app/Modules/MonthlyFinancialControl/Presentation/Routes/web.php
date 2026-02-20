<?php

use Illuminate\Support\Facades\Route;
use App\Modules\MonthlyFinancialControl\Presentation\Http\Controllers\MonthlyFinancialControlController;

Route::middleware(['web','auth','force_password_change'])->group(function () {
    Route::get('/monthly-controls', [MonthlyFinancialControlController::class, 'index'])->name('monthly-controls.index');
});
