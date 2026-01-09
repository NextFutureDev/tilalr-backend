<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$faker = Faker\Factory::create();
$ts = time();
$slug = 'e2e-test-offer-' . $ts;
$offer = \App\Models\Offer::create([
    'slug' => $slug,
    'image' => 'storage/offers/test-e2e.jpg',
    'title_en' => 'E2E Test Offer ' . $ts,
    'title_ar' => 'اختبار E2E ' . $ts,
    'description_en' => 'E2E description',
    'description_ar' => 'وصف E2E',
    'duration' => '1 Day',
    'location_en' => 'Test City',
    'location_ar' => 'مدينة الاختبار',
    'group_size' => '1-5',
    'discount' => '5%',
    'badge' => 'E2E',
    'features' => json_encode(['f1','f2']),
    'highlights' => json_encode(['h1','h2']),
    'is_active' => true,
]);

echo "Created offer id: {$offer->id}, slug: {$offer->slug}\n";
