<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;charset=utf8', 'root', '');
$db = 'laravel';
try {
    $pdo->exec("ALTER TABLE `$db`.users MODIFY COLUMN `email` VARCHAR(255) NULL");
    echo "Made email nullable in $db.users\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
