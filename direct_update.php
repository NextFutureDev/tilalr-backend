<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Direct update using query builder to ensure it works
\DB::table('trips')->where('id', 13)->update([
    'title_trans' => json_encode(['ar' => 'night']),
    'description_trans' => null,
    'content_trans' => null,
]);

echo "Updated trip 13\n";

// Verify
$trip = \DB::table('trips')->where('id', 13)->first();
echo "Trip data: " . json_encode($trip, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
?>
