<?php

namespace App\Providers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class CsrfTokenResponseProvider extends ServiceProvider
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
        // Ensure every HTML response includes the current CSRF token
        // This helps Livewire and AJAX requests always have the latest token
        Response::macro('withCsrfToken', function ($view = null) {
            return response()
                ->view($view ?? request()->route()?->getName())
                ->header('X-CSRF-TOKEN', csrf_token());
        });
    }
}
