<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Hash;
use App\Models\User;

$user = User::where('email', 'superadmin@tilalr.com')->first();
if (!$user) {
    echo "NOT FOUND\n";
    exit(0);
}
$check = Hash::check('superadmin123', $user->password) ? 'MATCH' : 'NO_MATCH';
echo "USER ID: {$user->id}\n";
echo "EMAIL: {$user->email}\n";
echo "IS_ADMIN: " . ($user->is_admin ? 'yes' : 'no') . "\n";
echo "PASSWORD CHECK: {$check}\n";
