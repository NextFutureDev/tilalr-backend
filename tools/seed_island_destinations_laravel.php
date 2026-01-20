<?php
$dsn = 'mysql:host=127.0.0.1;port=3306;dbname=laravel';
$user = 'root';
$pass = '';
try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
    $now = date('Y-m-d H:i:s');
    $stmt = $pdo->prepare("INSERT INTO island_destinations (slug, title_en, title_ar, description_en, description_ar, features, image, price, rating, type, active, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $data = [
        ['maldives-paradise', 'Maldives Paradise Island', 'جزيرة المالديف الفردوس', 'Experience luxury at its finest with crystal clear waters and pristine beaches.', 'اختبر الرفاهية مع مياه صافية وشواطئ خلابة.', json_encode(['Water Sports','Spa & Wellness','Fine Dining','Snorkeling']), 'http://127.0.0.1:8000/storage/islands/maldives.jpg', '2500.00', '4.8', 'international', 1, $now, $now],
        ['alula-adventure', 'AlUla Adventure', 'رحلة العلا', 'Join us on a trip to AlUla, discover amazing landscapes and heritage.', 'انضم إلينا في رحلة إلى العلا لاكتشاف المناظر الخلابة والتراث.', json_encode(['Hegra Visit','Desert Camping','Star Gazing']), null, '354.00', '4.9', 'local', 1, $now, $now]
    ];

    foreach ($data as $row) {
        $stmt->execute($row);
    }
    echo "Seeded island_destinations in 'laravel' DB\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
