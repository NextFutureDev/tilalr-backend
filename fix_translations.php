<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Find trips without proper title_trans and populate them
$trips = \App\Models\Trip::whereNull('title_trans')->orWhere('title_trans', '{}')->get();

echo "Found " . count($trips) . " trips without proper translations\n";

foreach ($trips as $trip) {
    echo "Fixing Trip #" . $trip->id . ": " . $trip->title . " (lang: " . $trip->lang . ")\n";
    
    // Build the translation arrays based on the trip's lang
    $title_trans = [];
    $description_trans = [];
    $content_trans = [];
    
    // If main fields are populated, use them for the corresponding language
    if ($trip->title) {
        $title_trans[$trip->lang] = $trip->title;
    }
    if ($trip->description) {
        $description_trans[$trip->lang] = $trip->description;
    }
    if ($trip->content) {
        $content_trans[$trip->lang] = $trip->content;
    }
    
    // Update the trip
    $trip->update([
        'title_trans' => !empty($title_trans) ? $title_trans : null,
        'description_trans' => !empty($description_trans) ? $description_trans : null,
        'content_trans' => !empty($content_trans) ? $content_trans : null,
    ]);
    
    echo "  → Updated translations\n";
}

echo "\n✓ Done! All trips now have proper translation fields.\n";
?>
