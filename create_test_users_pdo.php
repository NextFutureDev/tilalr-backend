<?php
require 'vendor/autoload.php';
$app = require_once('bootstrap/app.php');

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Support\Facades\Hash;

// Simple direct approach using PDO
$pdo = new PDO('mysql:host=localhost;dbname=tilrimal', 'root', '');

$users = [
    ['name' => 'Executive Manager', 'email' => 'executive@example.com', 'password' => 'password123'],
    ['name' => 'Consultant', 'email' => 'consultant@example.com', 'password' => 'password123'],
    ['name' => 'Admin User', 'email' => 'admin@example.com', 'password' => 'password123'],
];

foreach ($users as $user) {
    $hashed = password_hash($user['password'], PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT IGNORE INTO users (name, email, password, is_admin, created_at, updated_at) VALUES (?, ?, ?, 0, NOW(), NOW())");
    $stmt->execute([$user['name'], $user['email'], $hashed]);
    echo "Created/Updated: {$user['email']}\n";
}

echo "Done!\n";
