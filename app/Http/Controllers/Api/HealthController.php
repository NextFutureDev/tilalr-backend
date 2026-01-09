<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HealthController extends Controller
{
    /**
     * Health check endpoint - no database required
     */
    public function check()
    {
        return response()->json([
            'status' => 'ok',
            'message' => 'API is running',
            'timestamp' => now(),
        ]);
    }
    
    /**
     * Database connection test
     */
    public function dbTest()
    {
        try {
            \DB::connection()->getPdo();
            return response()->json([
                'database' => 'connected',
                'connection' => config('database.default'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'connection_attempted' => config('database.default'),
            ], 500);
        }
    }
}
