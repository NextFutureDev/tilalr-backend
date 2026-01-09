<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogLivewireRequests
{
    public function handle(Request $request, Closure $next)
    {
        if (!app()->environment('local')) {
            return $next($request);
        }

        $path = ltrim($request->path(), '/');

        if (str_starts_with($path, 'livewire/message')) {
            try {
                Log::debug('Livewire: incoming request', [
                    'path' => $path,
                    'method' => $request->method(),
                    'headers' => array_intersect_key($request->headers->all(), array_flip(['x-livewire', 'x-csrf-token', 'x-requested-with'])),
                    'payload' => $request->all(),
                ]);
            } catch (\Throwable $e) {
                Log::debug('Livewire: failed to log incoming request: ' . $e->getMessage());
            }

            $response = $next($request);

            try {
                Log::debug('Livewire: response', [
                    'path' => $path,
                    'status' => method_exists($response, 'getStatusCode') ? $response->getStatusCode() : null,
                    'body_snippet' => strlen($response->getContent()) > 1000 ? substr($response->getContent(), 0, 1000) . '...' : $response->getContent(),
                ]);
            } catch (\Throwable $e) {
                Log::debug('Livewire: failed to log response: ' . $e->getMessage());
            }

            return $response;
        }

        return $next($request);
    }
}
