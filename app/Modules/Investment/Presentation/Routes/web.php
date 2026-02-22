<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Investment\Presentation\Http\Controllers\InvestmentController;

Route::middleware(['web','auth','force_password_change'])->group(function () {
    Route::get('/investments', [InvestmentController::class, 'index'])->name('investments.index');
    Route::get('/investments/create', [InvestmentController::class, 'create'])->name('investments.create');
    Route::post('/investments', [InvestmentController::class, 'store'])->name('investments.store');
    Route::get('/investments/{id}', [InvestmentController::class, 'show'])->name('investments.show');
    Route::get('/investments/{id}/edit', [InvestmentController::class, 'edit'])->name('investments.edit');
    Route::put('/investments/{id}', [InvestmentController::class, 'update'])->name('investments.update');
    Route::delete('/investments/{id}', [InvestmentController::class, 'destroy'])->name('investments.destroy');
});
