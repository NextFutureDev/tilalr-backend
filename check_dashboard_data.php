<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== DATABASE COUNTS ===\n\n";

// Get all tables
$tables = DB::select('SHOW TABLES');
$dbName = env('DB_DATABASE', 'tilalrimal');
$tableKey = "Tables_in_$dbName";

foreach ($tables as $table) {
    $tableName = $table->$tableKey ?? $table->{array_keys((array)$table)[0]};
    try {
        $count = DB::table($tableName)->count();
        if ($count > 0) {
            echo "$tableName: $count\n";
        }
    } catch (Exception $e) {
        echo "$tableName: ERROR - " . $e->getMessage() . "\n";
    }
}

echo "\n=== KEY MODEL COUNTS ===\n\n";

$models = [
    'User' => 'App\Models\User',
    'Contact' => 'App\Models\Contact',
    'Trip' => 'App\Models\Trip',
    'Offer' => 'App\Models\Offer',
    'Service' => 'App\Models\Service',
    'IslandDestination' => 'App\Models\IslandDestination',
    'Reservation' => 'App\Models\Reservation',
    'InternationalDestination' => 'App\Models\InternationalDestination',
    'Payment' => 'App\Models\Payment',
];

foreach ($models as $name => $class) {
    if (class_exists($class)) {
        try {
            $count = $class::count();
            echo "$name: $count\n";
        } catch (Exception $e) {
            echo "$name: ERROR - " . $e->getMessage() . "\n";
        }
    } else {
        echo "$name: Model class not found\n";
    }
}
