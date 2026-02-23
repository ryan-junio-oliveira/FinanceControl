<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Register route middleware aliases
        if ($this->app->bound('router')) {
            $this->app['router']->aliasMiddleware('force_password_change', \App\Http\Middleware\ForcePasswordChange::class);
            $this->app['router']->aliasMiddleware('organization', \App\Http\Middleware\EnsureOrganization::class);
            // from spatie/laravel-permission (requires composer install & migration)
            $this->app['router']->aliasMiddleware('role', RoleMiddleware::class);
            $this->app['router']->aliasMiddleware('permission', PermissionMiddleware::class);
        }
    }
}
