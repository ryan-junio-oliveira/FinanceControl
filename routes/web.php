<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
    // Placeholder for password reset
    return back()->with('status', 'Link enviado (placeholder)');
})->name('password.email');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // CRUD Despesas
    Route::get('/expenses', [App\Http\Controllers\ExpenseController::class, 'index'])->name('expenses.index');
    Route::get('/expenses/create', [App\Http\Controllers\ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/expenses', [App\Http\Controllers\ExpenseController::class, 'store'])->name('expenses.store');
    Route::get('/expenses/{expense}/edit', [App\Http\Controllers\ExpenseController::class, 'edit'])->name('expenses.edit');
    Route::put('/expenses/{expense}', [App\Http\Controllers\ExpenseController::class, 'update'])->name('expenses.update');
    Route::delete('/expenses/{expense}', [App\Http\Controllers\ExpenseController::class, 'destroy'])->name('expenses.destroy');

    // CRUD Receitas
    Route::get('/recipes', [App\Http\Controllers\RecipeController::class, 'index'])->name('recipes.index');
    Route::get('/recipes/create', [App\Http\Controllers\RecipeController::class, 'create'])->name('recipes.create');
    Route::post('/recipes', [App\Http\Controllers\RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/recipes/{recipe}/edit', [App\Http\Controllers\RecipeController::class, 'edit'])->name('recipes.edit');
    Route::put('/recipes/{recipe}', [App\Http\Controllers\RecipeController::class, 'update'])->name('recipes.update');
    Route::delete('/recipes/{recipe}', [App\Http\Controllers\RecipeController::class, 'destroy'])->name('recipes.destroy');

    // CRUD Controles Mensais
    Route::get('/monthly-controls', [App\Http\Controllers\MonthlyFinancialControlController::class, 'index'])->name('monthly-controls.index');
    Route::get('/monthly-controls/create', [App\Http\Controllers\MonthlyFinancialControlController::class, 'create'])->name('monthly-controls.create');
    Route::post('/monthly-controls', [App\Http\Controllers\MonthlyFinancialControlController::class, 'store'])->name('monthly-controls.store');
    Route::get('/monthly-controls/{monthly_control}/edit', [App\Http\Controllers\MonthlyFinancialControlController::class, 'edit'])->name('monthly-controls.edit');
    Route::put('/monthly-controls/{monthly_control}', [App\Http\Controllers\MonthlyFinancialControlController::class, 'update'])->name('monthly-controls.update');
    Route::delete('/monthly-controls/{monthly_control}', [App\Http\Controllers\MonthlyFinancialControlController::class, 'destroy'])->name('monthly-controls.destroy');

    // CRUD Bancos & Cartões
    Route::resource('banks', App\Http\Controllers\BankController::class)->except(['show']);
    Route::resource('credit-cards', App\Http\Controllers\CreditCardController::class);

    // CRUD Categorias
    Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [App\Http\Controllers\CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [App\Http\Controllers\CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [App\Http\Controllers\CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [App\Http\Controllers\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('categories.destroy');

    // Organization (settings / members)
    Route::get('/organization', [App\Http\Controllers\OrganizationController::class, 'edit'])->name('organization.edit');
    Route::put('/organization', [App\Http\Controllers\OrganizationController::class, 'update'])->name('organization.update');
    Route::post('/organization/invite', [App\Http\Controllers\OrganizationController::class, 'inviteMember'])->name('organization.invite');
    Route::delete('/organization/members/{user}', [App\Http\Controllers\OrganizationController::class, 'removeMember'])->name('organization.members.remove');
    Route::post('/organization/archive', [App\Http\Controllers\OrganizationController::class, 'archive'])->name('organization.archive');
    Route::post('/organization/unarchive', [App\Http\Controllers\OrganizationController::class, 'unarchive'])->name('organization.unarchive');
    Route::delete('/organization', [App\Http\Controllers\OrganizationController::class, 'destroy'])->name('organization.destroy');

    // CRUD Orçamentos
    Route::get('/budgets', [App\Http\Controllers\BudgetController::class, 'index'])->name('budgets.index');
    Route::get('/budgets/create', [App\Http\Controllers\BudgetController::class, 'create'])->name('budgets.create');
    Route::post('/budgets', [App\Http\Controllers\BudgetController::class, 'store'])->name('budgets.store');
    Route::get('/budgets/{budget}/edit', [App\Http\Controllers\BudgetController::class, 'edit'])->name('budgets.edit');
    Route::put('/budgets/{budget}', [App\Http\Controllers\BudgetController::class, 'update'])->name('budgets.update');
    Route::get('/budgets/{budget}', [App\Http\Controllers\BudgetController::class, 'show'])->name('budgets.show');
    Route::delete('/budgets/{budget}', [App\Http\Controllers\BudgetController::class, 'destroy'])->name('budgets.destroy');
});
