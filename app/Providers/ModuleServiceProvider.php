<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register services for all modules (bindings, listeners, etc.)
     */
    public function register(): void
    {
        // Example: bind module repository interfaces to implementations.
        $this->app->bind(
            \App\Modules\Budget\Domain\Contracts\BudgetRepositoryInterface::class,
            \App\Modules\Budget\Infrastructure\Persistence\Eloquent\BudgetRepository::class
        );

        // other module bindings
        $this->app->bind(
            \App\Modules\Expense\Domain\Contracts\ExpenseRepositoryInterface::class,
            \App\Modules\Expense\Infrastructure\Persistence\Eloquent\ExpenseRepository::class
        );
        $this->app->bind(
            \App\Modules\Category\Domain\Contracts\CategoryRepositoryInterface::class,
            \App\Modules\Category\Infrastructure\Persistence\Eloquent\CategoryRepository::class
        );
        $this->app->bind(
            \App\Modules\Recipe\Domain\Contracts\RecipeRepositoryInterface::class,
            \App\Modules\Recipe\Infrastructure\Persistence\Eloquent\RecipeRepository::class
        );
        $this->app->bind(
            \App\Modules\Organization\Domain\Contracts\OrganizationRepositoryInterface::class,
            \App\Modules\Organization\Infrastructure\Persistence\Eloquent\OrganizationRepository::class
        );
        $this->app->bind(
            \App\Modules\Bank\Domain\Contracts\BankRepositoryInterface::class,
            \App\Modules\Bank\Infrastructure\Persistence\Eloquent\BankRepository::class
        );

        // application use-case bindings
        $this->app->bind(
            \App\Modules\Bank\Application\Contracts\ListBanksInterface::class,
            \App\Modules\Bank\Application\UseCases\ListBanks::class
        );
        $this->app->bind(
            \App\Modules\CreditCard\Domain\Contracts\CreditCardRepositoryInterface::class,
            \App\Modules\CreditCard\Infrastructure\Persistence\Eloquent\CreditCardRepository::class
        );

        // read‑model repository for credit cards (returns DTOs used by presentation)
        $this->app->bind(
            \App\Modules\CreditCard\Application\Contracts\CreditCardViewRepositoryInterface::class,
            \App\Modules\CreditCard\Infrastructure\Persistence\Eloquent\CreditCardViewRepository::class
        );
        $this->app->bind(
            \App\Modules\MonthlyFinancialControl\Domain\Contracts\MonthlyFinancialControlRepositoryInterface::class,
            \App\Modules\MonthlyFinancialControl\Infrastructure\Persistence\Eloquent\MonthlyFinancialControlRepository::class
        );
    }

    /**
     * Bootstrap any module services.
     */
    public function boot(): void
    {
        // Optionally load module routes here.
        $this->loadModuleRoutes();
    }

    protected function loadModuleRoutes(): void
    {
        $moduleRouteFiles = glob(app_path('Modules/*/Presentation/Routes/*.php')) ?: [];

        foreach ($moduleRouteFiles as $file) {
            $this->loadRoutesFrom($file);
        }
    }
}
