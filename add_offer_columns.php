<?php
/**
 * One-time script to add missing offer columns
 * Visit: http://localhost:8000/add_offer_columns.php
 * Then delete this file
 */

try {
    $host = env('DB_HOST', 'localhost');
    $user = env('DB_USERNAME', 'root');
    $pass = env('DB_PASSWORD', '');
    $database = env('DB_DATABASE', 'tilrimal');

    $mysqli = new mysqli($host, $user, $pass, $database);

    if ($mysqli->connect_error) {
        die('Connection failed: ' . $mysqli->connect_error);
    }

    $sql = "ALTER TABLE `offers`
    ADD COLUMN `duration_en` VARCHAR(255) NULL AFTER `description_en`,
    ADD COLUMN `duration_ar` VARCHAR(255) NULL AFTER `duration_en`,
    ADD COLUMN `group_size_en` VARCHAR(255) NULL AFTER `group_size`,
    ADD COLUMN `group_size_ar` VARCHAR(255) NULL AFTER `group_size_en`,
    ADD COLUMN `badge_en` VARCHAR(255) NULL AFTER `badge`,
    ADD COLUMN `badge_ar` VARCHAR(255) NULL AFTER `badge_en`,
    ADD COLUMN `features_en` JSON NULL AFTER `features`,
    ADD COLUMN `features_ar` JSON NULL AFTER `features_en`,
    ADD COLUMN `highlights_en` JSON NULL AFTER `highlights`,
    ADD COLUMN `highlights_ar` JSON NULL AFTER `highlights_en`;";

    if ($mysqli->multi_query($sql)) {
        echo "<h2 style='color: green;'>✅ SUCCESS! All columns added to offers table.</h2>";
        echo "<p>The following columns were created:</p>";
        echo "<ul>
            <li>duration_en, duration_ar</li>
            <li>group_size_en, group_size_ar</li>
            <li>badge_en, badge_ar</li>
            <li>features_en, features_ar</li>
            <li>highlights_en, highlights_ar</li>
        </ul>";
        echo "<p><strong>⚠️ IMPORTANT:</strong> Delete this file (add_offer_columns.php) from your server for security.</p>";
        echo "<p>Then refresh your Filament admin page and try saving an offer again.</p>";
    } else {
        echo "<h2 style='color: red;'>❌ ERROR:</h2>";
        echo "<pre>" . $mysqli->error . "</pre>";
    }

    $mysqli->close();

} catch (Exception $e) {
    echo "<h2 style='color: red;'>ERROR: " . $e->getMessage() . "</h2>";
}
?>
