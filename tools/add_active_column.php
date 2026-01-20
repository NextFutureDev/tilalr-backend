<?php
$dsn = 'mysql:host=127.0.0.1;port=3306;dbname=laravel';
$user = 'root';
$pass = '';
try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
    $pdo->exec("ALTER TABLE `island_destinations` ADD COLUMN IF NOT EXISTS `active` TINYINT(1) DEFAULT 1 AFTER `features`");
    echo "Added active column if missing\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
