<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Blade;

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
        Blade::if('organizer', function () {
            return auth()->check() && auth()->user()->role === 'organizer';
        });
        Blade::if('participant', function () {
            return auth()->check() && auth()->user()->role === 'participant';
        });
        Blade::if('visitor', function () {
            return auth()->check() && auth()->user()->role === 'visitor';
        });
    }
}
