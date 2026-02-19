<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register route middleware alias for forcing password change after invite
        if ($this->app->bound('router')) {
            $this->app['router']->aliasMiddleware('force_password_change', \App\Http\Middleware\ForcePasswordChange::class);
        }
    }
}
