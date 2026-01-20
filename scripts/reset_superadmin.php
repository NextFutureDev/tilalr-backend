<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$pass = bin2hex(random_bytes(8));
$userModel = new \App\Models\User();

$user = \App\Models\User::where('email', 'superadmin@tilalr.com')->first();
if (! $user) {
    $user = \App\Models\User::create([
        'name' => 'Super Admin',
        'email' => 'superadmin@tilalr.com',
        'password' => bcrypt($pass),
        'is_admin' => 1,
    ]);
} else {
    $user->password = bcrypt($pass);
    $user->save();
}

echo "UPDATED:" . $user->email . PHP_EOL;
echo "NEW_PASSWORD=" . $pass . PHP_EOL;
