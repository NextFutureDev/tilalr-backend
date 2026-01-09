<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;

trait HasLocaleHandling
{
    /**
     * Set locale from request segment
     */
    protected function setLocaleFromRequest($request): void
    {
        $locale = $request->segment(1);
        if (in_array($locale, ['en', 'ar'])) {
            App::setLocale($locale);
            session(['locale' => $locale]);
        }
    }
}
