<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo 'DB_CONNECTION=' . config('database.default') . PHP_EOL;
echo 'DB_DATABASE=' . config('database.connections.' . config('database.default') . '.database') . PHP_EOL;
