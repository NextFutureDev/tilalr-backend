<?php
// Simple script to create a test Offer and print counts. Run from project root:
// php create_offer_debug.php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Offer;

try {
    $offer = Offer::create([
        'slug' => 'debug-offer-' . time(),
        'title_en' => 'Debug Offer ' . date('Y-m-d H:i:s'),
        'title_ar' => 'عرض تصحيح' . date('Y-m-d H:i:s'),
        'description_en' => 'Created by debug script',
        'description_ar' => 'تم الإنشاء بواسطة سكربت التصحيح',
        'duration' => '1 Day',
        'location_en' => 'Test Location',
        'group_size' => '2-10',
        'discount' => '10%',
        'badge' => 'Debug',
        'features' => ['feature A', 'feature B'],
        'highlights' => ['highlight A'],
        'is_active' => true,
    ]);

    echo "Created offer id: {$offer->id}\n";
    echo "Total offers: " . Offer::count() . "\n";
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
