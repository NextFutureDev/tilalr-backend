<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$trips = \App\Models\Trip::orderBy('created_at','desc')->limit(5)->get(['id','title','lang','created_at']);
echo json_encode($trips, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) . "\n";
