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
        // Set locale from URL segment, but respect session if it was recently set
        $locale = request()->segment(1);
        $sessionLocale = session('locale');
        $flashLocale = session('current_locale'); // Check for flash session data
        $cookieLocale = request()->cookie('locale'); // Check for cookie
        
        // Priority: Flash session > Cookie > Session > URL segment > Default
        if ($flashLocale && in_array($flashLocale, ['en', 'ar'])) {
            app()->setLocale($flashLocale);
            session(['locale' => $flashLocale]); // Persist flash to session
        } elseif ($cookieLocale && in_array($cookieLocale, ['en', 'ar'])) {
            app()->setLocale($cookieLocale);
            session(['locale' => $cookieLocale]); // Persist cookie to session
        } elseif ($sessionLocale && in_array($sessionLocale, ['en', 'ar'])) {
            app()->setLocale($sessionLocale);
        } elseif (in_array($locale, ['en', 'ar'])) {
            app()->setLocale($locale);
            session(['locale' => $locale]); // Persist URL to session
        } else {
            // Fallback to default
            app()->setLocale('en');
            session(['locale' => 'en']); // Persist default to session
        }
        
        // Handle file upload errors gracefully
        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Foundation\Events\ExceptionReported::class,
            function ($event) {
                if ($event->exception instanceof \League\Flysystem\UnableToRetrieveMetadata) {
                    // Log the error but don't crash the application
                    \Illuminate\Support\Facades\Log::warning('File metadata retrieval failed: ' . $event->exception->getMessage());
                }
            }
        );

        // Clean up temporary files periodically
        if (app()->environment('local')) {
            $tempPath = storage_path('app/livewire-tmp');
            if (is_dir($tempPath)) {
                $files = glob($tempPath . '/*');
                $now = time();
                foreach ($files as $file) {
                    if (is_file($file) && ($now - filemtime($file)) > 3600) { // 1 hour old
                        @unlink($file);
                    }
                }
            }
        }
    }
}
