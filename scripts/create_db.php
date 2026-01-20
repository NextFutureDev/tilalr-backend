<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1', 'root', '');
    $pdo->exec("CREATE DATABASE IF NOT EXISTS tilrimal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    echo "DB created or already exists\n";
} catch (PDOException $e) {
    echo 'PDO error: ' . $e->getMessage() . "\n";
}
