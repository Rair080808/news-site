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
        // Русская локаль для Carbon (русские названия месяцев в датах статей)
        \Carbon\Carbon::setLocale(config('app.locale', 'ru'));
    }
}