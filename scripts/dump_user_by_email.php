<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use App\Models\User;
$email = 'amanshah12sweer@gmail.com';
$user = User::where('email', $email)->first();
if ($user) {
    echo json_encode(['id' => $user->id, 'email' => $user->email, 'phone' => $user->phone], JSON_PRETTY_PRINT);
} else {
    echo 'NOT FOUND';
}
