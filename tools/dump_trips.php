<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$trips = App\Models\Trip::select('id','slug','title','lang','is_active','created_at')
    ->orderBy('created_at','desc')
    ->take(20)
    ->get()
    ->toArray();

echo json_encode($trips, JSON_PRETTY_PRINT);
