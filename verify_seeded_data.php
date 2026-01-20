<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$destinations = \App\Models\IslandDestination::where('type', 'local')->orderBy('price')->get();

echo "=== SEEDED LOCAL ISLAND DESTINATIONS ===\n\n";
foreach ($destinations as $dest) {
    echo "Trip: " . $dest->title_en . "\n";
    echo "Price: " . $dest->price . " SAR\n";
    echo "Rating: " . $dest->rating . "\n";
    echo "Duration: " . $dest->duration_en . "\n";
    echo "Group Size: " . $dest->groupSize_en . "\n";
    echo "Location: " . $dest->location_en . "\n";
    echo "Image: " . $dest->image . "\n";
    echo "Has Highlights: " . (!is_null($dest->highlights_en) ? "YES ✓" : "NO ✗") . "\n";
    echo "Has Includes: " . (!is_null($dest->includes_en) ? "YES ✓" : "NO ✗") . "\n";
    echo "Has Itinerary: " . (!is_null($dest->itinerary_en) ? "YES ✓ (" . strlen($dest->itinerary_en) . " chars)" : "NO ✗") . "\n";
    echo "\n---\n\n";
}

echo "✅ Database verification complete!\n";
?>
