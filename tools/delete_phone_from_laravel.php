<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;charset=utf8', 'root', '');
$deleted = $pdo->exec("DELETE FROM laravel.users WHERE phone = '0559999999'");
echo "Deleted rows: $deleted\n";
