<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Gate para administradores
        Gate::define('isAdmin', function ($user) {
            return $user->permisos === 0;
        });

        // Gate para usuarios estándar
        Gate::define('isUser', function ($user) {
            return $user->permisos === 1;
        });
    }
}
