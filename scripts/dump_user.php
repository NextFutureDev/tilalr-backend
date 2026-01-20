<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use App\Models\User;
$id = 20;
$u = User::find($id);
if ($u) {
    echo json_encode(['id' => $u->id, 'email' => $u->email, 'name' => $u->name], JSON_PRETTY_PRINT);
} else {
    echo 'NOT FOUND';
}
