<?php

use Illuminate\Support\Facades\Route;
use App\Modules\CreditCard\Presentation\Http\Controllers\CreditCardController;

Route::middleware(['web','auth','organization','force_password_change'])->group(function () {
    Route::get('/credit-cards', [CreditCardController::class, 'index'])->name('credit-cards.index');
    Route::get('/credit-cards/create', [CreditCardController::class, 'create'])->name('credit-cards.create');
    Route::post('/credit-cards', [CreditCardController::class, 'store'])->name('credit-cards.store');
    Route::get('/credit-cards/{id}/edit', [CreditCardController::class, 'edit'])->name('credit-cards.edit');
    Route::put('/credit-cards/{id}', [CreditCardController::class, 'update'])->name('credit-cards.update');
    Route::delete('/credit-cards/{id}', [CreditCardController::class, 'destroy'])->name('credit-cards.destroy');
});
