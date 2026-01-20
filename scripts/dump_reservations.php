<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use App\Models\Reservation;
$res = Reservation::orderBy('id','desc')->take(20)->get()->map(function($r){
    return [
        'id' => $r->id,
        'user_id' => $r->user_id,
        'email' => $r->email,
        'phone' => $r->phone,
        'created_at' => (string)$r->created_at,
    ];
});
echo json_encode($res->toArray(), JSON_PRETTY_PRINT);
