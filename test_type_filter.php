<?php
// Test script to verify island destination type filtering

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\IslandDestination;

// Count local vs international
$local = IslandDestination::where('type', 'local')->get();
$international = IslandDestination::where('type', 'international')->get();

echo "=== Island Destination Type Filtering ===\n";
echo "Local Destinations (" . $local->count() . "):\n";
foreach ($local as $d) {
    echo "  - {$d->title_en} (ID: {$d->id}, Type: {$d->type})\n";
}
echo "\nInternational Destinations (" . $international->count() . "):\n";
foreach ($international as $d) {
    echo "  - {$d->title_en} (ID: {$d->id}, Type: {$d->type})\n";
}
echo "\nTotal: " . IslandDestination::count() . " destinations\n";
