<?php
$databases = ['tilalrimal','laravel'];
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;charset=utf8', 'root', '');
foreach ($databases as $db) {
    $stmt = $pdo->prepare("SELECT COUNT(*) AS cnt FROM information_schema.columns WHERE table_schema = ? AND table_name = 'users' AND column_name = 'phone'");
    $stmt->execute([$db]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "DB: $db -> phone column exists? " . ($row['cnt'] > 0 ? 'YES' : 'NO') . "\n";
}
