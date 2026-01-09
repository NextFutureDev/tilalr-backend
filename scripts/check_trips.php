<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Trip;

echo "Total trips: " . Trip::count() . PHP_EOL;
echo "EN trips: " . Trip::where('lang', 'en')->count() . PHP_EOL;
echo "AR trips: " . Trip::where('lang', 'ar')->count() . PHP_EOL;
$events = Trip::where('type', 'event')->count();
echo "Event trips total: $events" . PHP_EOL;
$active = Trip::where('is_active', true)->count();
echo "Active trips: $active" . PHP_EOL;
$events_en = Trip::where('type', 'event')->where('lang', 'en')->count();
echo "Event EN: $events_en" . PHP_EOL;
$events_ar = Trip::where('type', 'event')->where('lang', 'ar')->count();
echo "Event AR: $events_ar" . PHP_EOL;

$sample = Trip::where('type', 'event')->with('city')->limit(10)->get();
echo PHP_EOL . "Sample events JSON:\n";
echo $sample->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL;
