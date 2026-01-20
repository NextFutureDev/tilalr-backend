<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Laravel\Sanctum\PersonalAccessToken;
$tokens = PersonalAccessToken::orderBy('id','desc')->take(20)->get()->map(function($t){
    return [
        'id' => $t->id,
        'name' => $t->name,
        'token_hash' => substr($t->token,0,8) . '... (hashed stored)',
        'tokenable_type' => $t->tokenable_type,
        'tokenable_id' => $t->tokenable_id,
        'created_at' => (string)$t->created_at,
    ];
});

echo json_encode($tokens->toArray(), JSON_PRETTY_PRINT);
