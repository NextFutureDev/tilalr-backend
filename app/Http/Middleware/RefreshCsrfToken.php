<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RefreshCsrfToken
{
    /**
     * Handle an incoming request.
     * 
     * This middleware only adds the CSRF token to response headers.
     * Token regeneration should NOT happen before validation as it causes 419 errors.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Add CSRF token to response headers for JavaScript access
        if ($request->hasSession()) {
            $response->header('X-CSRF-TOKEN', $request->session()->token());
        }

        return $response;
    }
}


