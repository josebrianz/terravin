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

        // Blade directive for checking if user can perform action on resource
        Blade::if('canPerform', function ($action, $resource) {
            return Auth::check() && Auth::user()->canPerform($action, $resource);
        });

        // Blade directive for checking if user can view own data
        Blade::if('canViewOwn', function ($resource) {
            return Auth::check() && Auth::user()->canViewOwn($resource);
        });

        // Blade directive for checking if user can view all data
        Blade::if('canViewAll', function ($resource) {
            return Auth::check() && Auth::user()->canViewAll($resource);
        });

        // Blade directive for checking if user has admin permissions
        Blade::if('hasAdminPermissions', function () {
            return Auth::check() && Auth::user()->hasAdminPermissions();
        });
    }
}
