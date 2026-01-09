<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Offer;

$offers = Offer::all();

echo "Offer count: " . $offers->count() . PHP_EOL;
foreach ($offers as $o) {
    echo "ID: {$o->id} | slug: {$o->slug} | title_en: {$o->title_en} | is_active: " . ($o->is_active ? '1' : '0') . "\n";
}
