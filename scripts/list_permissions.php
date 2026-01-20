<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Permission;

$perms = Permission::orderBy('name')->pluck('name')->toArray();
foreach ($perms as $p) {
    echo $p . PHP_EOL;
}
