<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;

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
        // Blade directive for checking roles
        Blade::if('role', function ($role) {
            return Auth::check() && Auth::user()->hasRole($role);
        });

        // Blade directive for checking permissions
        Blade::if('permission', function ($permission) {
            return Auth::check() && Auth::user()->hasPermission($permission);
        });

        // Blade directive for checking any permission
        Blade::if('anyPermission', function ($permissions) {
            return Auth::check() && Auth::user()->hasAnyPermission($permissions);
        });

        // Blade directive for checking all permissions
        Blade::if('allPermissions', function ($permissions) {
            return Auth::check() && Auth::user()->hasAllPermissions($permissions);
        });
    }
}
