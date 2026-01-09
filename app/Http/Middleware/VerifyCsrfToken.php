<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Support\Facades\Log;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];

    /**
     * Handle a request to verify the CSRF token.
     *
     * Overrides parent to add logging for debugging CSRF token mismatches.
     */
    public function handle($request, $next)
    {
        // Log all POST/PUT/DELETE requests for debugging
        if (in_array($request->method(), ['POST', 'PUT', 'DELETE', 'PATCH'])) {
            Log::debug('CSRF Verification Attempt', [
                'path' => $request->path(),
                'method' => $request->method(),
                'session_id' => $request->session()->getId() ?? 'none',
                'csrf_from_request' => substr($request->input('_token') ?? $request->header('X-CSRF-TOKEN') ?? 'none', 0, 20),
                'csrf_from_session' => substr($request->session()->token() ?? 'none', 0, 20),
                'cookie_present' => $request->hasCookie($this->getCookieName()) ? 'yes' : 'no',
            ]);
        }

        return parent::handle($request, $next);
    }

    /**
     * Get the CSRF cookie name from config.
     */
    protected function getCookieName()
    {
        return config('session.cookie');
    }
}
