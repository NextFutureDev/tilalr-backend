<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;charset=utf8', 'root', '');
$db = 'laravel';
$sql = <<<SQL
CREATE TABLE IF NOT EXISTS `$db`.personal_access_tokens (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `tokenable_type` VARCHAR(255) NOT NULL,
  `tokenable_id` BIGINT UNSIGNED NOT NULL,
  `name` TEXT NOT NULL,
  `token` VARCHAR(64) NOT NULL UNIQUE,
  `abilities` TEXT NULL,
  `last_used_at` TIMESTAMP NULL,
  `expires_at` TIMESTAMP NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL;
try {
    $pdo->exec($sql);
    echo "Created personal_access_tokens in $db\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
