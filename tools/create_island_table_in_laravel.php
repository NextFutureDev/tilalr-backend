<?php
$dsn = 'mysql:host=127.0.0.1;port=3306;dbname=laravel';
$user = 'root';
$pass = '';
try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
    $sql = "CREATE TABLE IF NOT EXISTS `island_destinations` (
        `id` bigint unsigned NOT NULL AUTO_INCREMENT,
        `slug` varchar(255) DEFAULT NULL,
        `title_en` varchar(255) DEFAULT NULL,
        `title_ar` varchar(255) DEFAULT NULL,
        `description_en` text,
        `description_ar` text,
        `features` json DEFAULT NULL,
        `image` varchar(255) DEFAULT NULL,
        `price` decimal(10,2) DEFAULT NULL,
        `rating` decimal(3,2) DEFAULT NULL,
        `city_id` bigint unsigned DEFAULT NULL,
        `type` varchar(255) DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `island_destinations_slug_unique` (`slug`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    $pdo->exec($sql);
    echo "Created table island_destinations in database 'laravel' (if it did not exist).\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
