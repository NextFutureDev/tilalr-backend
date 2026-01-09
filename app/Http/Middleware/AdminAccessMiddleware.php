<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            // Will be handled by Filament's Authenticate middleware
            return $next($request);
        }

        $user = Auth::user();
        
        // Check if user has any of the allowed roles OR is_admin
        $hasAccess = $user->is_admin || 
                     $user->hasRole('executive_manager') || 
                     $user->hasRole('consultant') || 
                     $user->hasRole('administration');
        
        if (!$hasAccess) {
            // User is authenticated but not authorized
            abort(403, 'Access denied. You do not have permission to access this area.');
        }

        return $next($request);
    }
}
