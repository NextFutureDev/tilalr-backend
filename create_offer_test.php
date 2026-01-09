<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Offer;

$offer = Offer::create([
    'slug' => 'test-offer-' . time(),
    'image' => '/offers/test.jpg',
    'title_en' => 'Test Offer',
    'title_ar' => 'اختبار العرض',
    'description_en' => 'Test description',
    'description_ar' => 'وصف الاختبار',
    'duration' => '1 Day',
    'location_en' => 'Test City',
    'location_ar' => 'مدينة الاختبار',
    'group_size' => '1-5',
    'discount' => '10%',
    'badge' => 'Test',
    'features' => json_encode(['f1','f2']),
    'highlights' => json_encode(['h1','h2']),
    'is_active' => true,
]);

echo "Created offer id: " . $offer->id . PHP_EOL;
echo "Total offers: " . Offer::count() . PHP_EOL;
