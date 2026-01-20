<?php
$hosts = [
    ['host'=>'127.0.0.1','port'=>3306,'db'=>'tilalrimal'],
    ['host'=>'127.0.0.1','port'=>3306,'db'=>'laravel'],
];
$user = 'root';
$pass = '';
foreach ($hosts as $h) {
    try {
        $dsn = "mysql:host={$h['host']};port={$h['port']};dbname={$h['db']}";
        $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
        $stmt = $pdo->query("SHOW TABLES LIKE 'island_destinations'");
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "DB={$h['db']} -> " . (count($res) ? 'FOUND' : 'MISSING') . "\n";
    } catch (Exception $e) {
        echo "DB={$h['db']} -> ERROR: " . $e->getMessage() . "\n";
    }
}
