<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Offers count: " . \App\Models\Offer::count() . "\n";
\App\Models\Offer::all()->each(function($o) {
    echo "{$o->id} - {$o->title_en}\n";
});
