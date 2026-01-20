<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use App\Models\Reservation;
use App\Models\User;

$unlinked = Reservation::whereNull('user_id')->get();
$linked = [];
foreach ($unlinked as $r) {
    if (!$r->email) continue;
    $user = User::where('email', $r->email)->first();
    if ($user) {
        $r->user_id = $user->id;
        $r->save();
        $linked[] = ['reservation_id' => $r->id, 'user_id' => $user->id, 'email' => $r->email];
    }
}

echo "Linked reservations:\n";
echo json_encode($linked, JSON_PRETTY_PRINT);
