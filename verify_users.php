<?php
// Verify database connection
$host = '127.0.0.1';
$db = 'tilalrimal';
$user = 'root';
$pass = '';

$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

// Check if test users exist
$result = $pdo->query("SELECT id, name, email FROM users WHERE email IN ('executive@example.com', 'consultant@example.com', 'admin@example.com')");
$users = $result->fetchAll(PDO::FETCH_ASSOC);

echo "TEST USERS:\n";
foreach ($users as $u) {
    echo "ID: {$u['id']}, Name: {$u['name']}, Email: {$u['email']}\n";
    
    // Check roles
    $roleResult = $pdo->prepare("SELECT r.id, r.name FROM roles r INNER JOIN role_user ru ON r.id = ru.role_id WHERE ru.user_id = ?");
    $roleResult->execute([$u['id']]);
    $roles = $roleResult->fetchAll(PDO::FETCH_ASSOC);
    
    if ($roles) {
        foreach ($roles as $role) {
            echo "  → Role: {$role['name']} (ID: {$role['id']})\n";
        }
    }
}

// Check database connection status
echo "\nDATABASE CONNECTION:\n";
try {
    $pdo->query("SELECT 1");
    echo "✓ MySQL connected successfully\n";
} catch (Exception $e) {
    echo "✗ MySQL connection failed: " . $e->getMessage() . "\n";
}
?>
