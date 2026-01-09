<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogSlowRequests
{
    public function handle(Request $request, Closure $next)
    {
        $start = microtime(true);

        $response = $next($request);

        $duration = (microtime(true) - $start) * 1000; // ms

        if ($duration > 2000) { // log requests slower than 2s
            Log::warning('Slow request detected', [
                'path' => $request->path(),
                'method' => $request->method(),
                'duration_ms' => round($duration, 2),
                'memory' => round(memory_get_usage(true) / 1024 / 1024, 2) . 'MB',
            ]);
        }

        return $response;
    }
}
