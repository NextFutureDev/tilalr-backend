<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== IMAGE URL TEST ===\n\n";

$destinations = \App\Models\IslandDestination::where('type', 'local')->get();

foreach ($destinations as $dest) {
    echo "Trip: {$dest->title_en}\n";
    echo "Database image field: {$dest->image}\n";
    
    // Simulate URL construction
    $backendBase = 'http://localhost:8000';
    
    if (strpos($dest->image, 'islands/') === 0) {
        $url = $backendBase . '/' . $dest->image;
    } else {
        $url = $backendBase . '/islands/' . $dest->image;
    }
    
    echo "Constructed URL: $url\n";
    echo "File exists at public: " . (file_exists("public/" . $dest->image) ? "YES" : "NO") . "\n";
    echo "---\n\n";
}
?>
