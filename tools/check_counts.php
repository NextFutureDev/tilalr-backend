<?php
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
echo 'Cities: '.\App\Models\City::count()."\n";
echo 'InternationalFlights: '.\App\Models\InternationalFlight::count()."\n";
