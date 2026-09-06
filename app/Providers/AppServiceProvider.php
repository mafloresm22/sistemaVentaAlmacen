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
        // Make Helper accessible globally (e.g. from Blade views) without a use statement
        class_alias(\App\Helpers\Helper::class, 'Helper');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}