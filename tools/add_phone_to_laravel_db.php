<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;charset=utf8', 'root', '');
$db = 'laravel';
try {
    $pdo->exec("ALTER TABLE `$db`.users ADD COLUMN phone VARCHAR(255) NULL");
    $pdo->exec("ALTER TABLE `$db`.users ADD UNIQUE INDEX unique_phone (phone)");
    echo "Added phone column to $db.users\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
