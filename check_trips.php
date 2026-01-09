<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$trips = \App\Models\Trip::select('id', 'title', 'lang', 'title_trans')
    ->orderBy('created_at', 'desc')
    ->limit(5)
    ->get();

echo json_encode($trips, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
