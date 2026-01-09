<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CsrfTokenProvider extends ServiceProvider
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
        // This provider just provides the service registration
        // Actual CSRF handling is done via middleware
    }
}
