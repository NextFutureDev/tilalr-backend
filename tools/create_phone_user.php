<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$phone = '0550000000';
$password = 'password123';

$user = User::updateOrCreate(
    ['phone' => $phone],
    [
        'name' => 'Phone User',
        'email' => 'phoneuser@example.com',
        'phone' => $phone,
        'password' => Hash::make($password),
        'is_admin' => false,
    ]
);

echo "Created/Updated Phone user: {$phone} / password: {$password}\n";
