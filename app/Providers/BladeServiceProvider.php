<?php

namespace App\Providers;

use App\Enums\UserRole;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // admin
        Blade::if('admin', function () {
            return auth()->user()->role_id == UserRole::Admin->value;
        });

        // sponsor
        Blade::if('sponsor', function () {
            return auth()->user()->role_id == UserRole::Sponsor->value;
        });

        // spaceowner/bbo
        Blade::if('bbo', function () {
            return auth()->user()->role_id == UserRole::AdSpaceOwner->value;
        });
    }
}
