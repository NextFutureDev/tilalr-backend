<?php
require 'vendor/autoload.php';
$app = require_once('bootstrap/app.php');

$users = $app->make('database')->connection()->table('users')->get(['id', 'name', 'email']);

echo "Total users: " . count($users) . "\n\n";
foreach ($users as $u) {
    echo "ID: {$u->id}, Name: {$u->name}, Email: {$u->email}\n";
}
