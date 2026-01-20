<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;charset=utf8', 'root', '');
foreach(['tilalrimal','laravel'] as $db) {
    $stmt = $pdo->prepare("SELECT id,email,phone FROM {$db}.users WHERE phone = ?");
    $stmt->execute(['0559999999']);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "$db: " . count($rows) . "\n";
    foreach ($rows as $r) echo json_encode($r) . "\n";
}
