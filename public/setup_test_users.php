<?php
/**
 * Web-accessible test user setup endpoint
 * Access at: http://localhost:8000/setup_test_users.php
 */

header('Content-Type: application/json');

$host = '127.0.0.1';
$db = 'tilalrimal';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    
    $testUsers = [
        ['name' => 'Executive Manager', 'email' => 'executive@example.com', 'password' => password_hash('password123', PASSWORD_BCRYPT), 'role_id' => 1],
        ['name' => 'Consultant', 'email' => 'consultant@example.com', 'password' => password_hash('password123', PASSWORD_BCRYPT), 'role_id' => 2],
        ['name' => 'Administration', 'email' => 'admin@example.com', 'password' => password_hash('password123', PASSWORD_BCRYPT), 'role_id' => 3],
    ];
    
    $created = [];
    
    foreach ($testUsers as $testUser) {
        // Check if user exists
        $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$testUser['email']]);
        $existing = $check->fetchColumn();
        
        if ($existing) {
            $userId = $existing;
            $created[] = ['email' => $testUser['email'], 'status' => 'already_exists', 'id' => $userId];
        } else {
            // Insert new user
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, is_admin, created_at, updated_at) VALUES (?, ?, ?, 0, NOW(), NOW())");
            $stmt->execute([$testUser['name'], $testUser['email'], $testUser['password']]);
            $userId = $pdo->lastInsertId();
            $created[] = ['email' => $testUser['email'], 'status' => 'created', 'id' => $userId];
        }
        
        // Assign role
        $roleCheck = $pdo->prepare("SELECT id FROM role_user WHERE user_id = ? AND role_id = ?");
        $roleCheck->execute([$userId, $testUser['role_id']]);
        
        if (!$roleCheck->fetchColumn()) {
            $roleStmt = $pdo->prepare("INSERT INTO role_user (user_id, role_id, created_at, updated_at) VALUES (?, ?, NOW(), NOW())");
            $roleStmt->execute([$userId, $testUser['role_id']]);
        }
    }
    
    // Verify
    $result = $pdo->query("SELECT u.id, u.name, u.email, r.name as role_name FROM users u LEFT JOIN role_user ru ON u.id = ru.user_id LEFT JOIN roles r ON ru.role_id = r.id WHERE u.email IN ('executive@example.com', 'consultant@example.com', 'admin@example.com')");
    $verified = $result->fetchAll();
    
    echo json_encode([
        'success' => true,
        'message' => 'Test users setup complete',
        'created' => $created,
        'verified' => $verified,
    ], JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
    ], JSON_PRETTY_PRINT);
}
?>
