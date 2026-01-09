<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Update trip 13 with description translation as well
\DB::table('trips')->where('id', 13)->update([
    'title_trans' => json_encode(['ar' => 'night']),
    'description_trans' => json_encode(['ar' => 'this is nghi2']),
    'content_trans' => null,
]);

echo "✓ Updated trip 13 with both title and description translations\n\nNow all trips should display correctly in both Arabic and English!\n";
?>
