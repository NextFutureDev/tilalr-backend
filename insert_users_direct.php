<?php
// Direct database insertion script
$host = '127.0.0.1';
$db = 'tilalrimal';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✓ Connected to database\n";
    
    // Create test users
    $users = [
        ['name' => 'Executive Manager', 'email' => 'executive@example.com', 'password' => password_hash('password123', PASSWORD_BCRYPT), 'role_id' => 1],
        ['name' => 'Consultant', 'email' => 'consultant@example.com', 'password' => password_hash('password123', PASSWORD_BCRYPT), 'role_id' => 2],
        ['name' => 'Administration', 'email' => 'admin@example.com', 'password' => password_hash('password123', PASSWORD_BCRYPT), 'role_id' => 3],
    ];
    
    foreach ($users as $u) {
        // Insert user
        $stmt = $pdo->prepare("INSERT IGNORE INTO users (name, email, password, is_admin, created_at, updated_at) VALUES (?, ?, ?, 0, NOW(), NOW())");
        $stmt->execute([$u['name'], $u['email'], $u['password']]);
        
        // Get user ID
        $userStmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $userStmt->execute([$u['email']]);
        $userId = $userStmt->fetchColumn();
        
        // Assign role
        $roleStmt = $pdo->prepare("INSERT IGNORE INTO role_user (user_id, role_id, created_at, updated_at) VALUES (?, ?, NOW(), NOW())");
        $roleStmt->execute([$userId, $u['role_id']]);
        
        echo "✓ Created user: {$u['email']} with role_id {$u['role_id']}\n";
    }
    
    // Verify
    $check = $pdo->query("SELECT COUNT(*) FROM users WHERE email IN ('executive@example.com', 'consultant@example.com', 'admin@example.com')");
    echo "\n✓ Total test users: " . $check->fetchColumn() . "\n";
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    die(1);
}
?>
