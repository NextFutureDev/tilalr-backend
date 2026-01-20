<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$dest = \App\Models\IslandDestination::where('slug', 'trip-to-alula')->first();

if ($dest) {
    echo "=== DESTINATION DATA ===\n";
    echo "Title: " . $dest->title_en . "\n";
    echo "Image field: " . $dest->image . "\n";
    echo "Image path: public/" . $dest->image . "\n";
    echo "File exists: " . (file_exists('public/' . $dest->image) ? "YES" : "NO") . "\n";
    echo "\n=== FULL ARRAY ===\n";
    $array = $dest->toArray();
    echo json_encode($array, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . "\n";
}
?>
