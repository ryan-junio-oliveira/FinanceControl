<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Budget\Presentation\Http\Controllers\BudgetController;

Route::middleware(['web','auth','force_password_change'])->group(function () {
    Route::get('/budgets', [BudgetController::class, 'index'])->name('budgets.index');
    Route::get('/budgets/create', [BudgetController::class, 'create'])->name('budgets.create');
    Route::post('/budgets', [BudgetController::class, 'store'])->name('budgets.store');
    Route::get('/budgets/{id}/edit', [BudgetController::class, 'edit'])->name('budgets.edit');
    Route::put('/budgets/{id}', [BudgetController::class, 'update'])->name('budgets.update');
    Route::get('/budgets/{id}', [BudgetController::class, 'show'])->name('budgets.show');
    Route::delete('/budgets/{id}', [BudgetController::class, 'destroy'])->name('budgets.destroy');
});
