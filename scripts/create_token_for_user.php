<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use App\Models\User;
$user = User::find(20);
if (!$user) { echo 'USER NOT FOUND'; exit(1); }
$token = $user->createToken('test-token')->plainTextToken;
echo $token . PHP_EOL;
