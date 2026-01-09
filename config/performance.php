<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Performance Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains performance-related configurations for the application.
    | These settings help optimize the application for better performance.
    |
    */

    'database' => [
        'query_timeout' => env('DB_QUERY_TIMEOUT', 30),
        'max_connections' => env('DB_MAX_CONNECTIONS', 100),
        'min_connections' => env('DB_MIN_CONNECTIONS', 5),
    ],

    'cache' => [
        'default_ttl' => env('CACHE_TTL', 3600),
        'query_cache_ttl' => env('QUERY_CACHE_TTL', 1800),
        'view_cache_ttl' => env('VIEW_CACHE_TTL', 7200),
    ],

    'filament' => [
        'table_pagination' => [
            'default' => 25,
            'options' => [10, 25, 50, 100],
        ],
        'image_lazy_loading' => true,
        'query_optimization' => true,
        'max_records_per_page' => 100,
    ],

    'optimization' => [
        'eager_loading' => true,
        'query_selects' => true,
        'database_indexes' => true,
        'compression' => true,
    ],
];
