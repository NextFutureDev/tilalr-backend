<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\IslandDestination;

echo "=== ISLAND DESTINATION TYPES ===\n\n";

$destinations = IslandDestination::all();

echo "All island destinations:\n";
foreach ($destinations as $dest) {
    echo "ID {$dest->id}: {$dest->title_en} - Type: '{$dest->type}'\n";
}

echo "\nUnique types:\n";
$types = IslandDestination::distinct()->pluck('type');
foreach ($types as $type) {
    echo "- '$type'\n";
}