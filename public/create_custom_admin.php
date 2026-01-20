<?php
/**
 * Create admin user with custom email
 * Access at: http://localhost:8000/create_custom_admin.php
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
    
    $newUser = [
        'name' => 'Executive Admin',
        'email' => 'executive@tilalr.com',
        'password' => password_hash('password123', PASSWORD_BCRYPT),
        'is_admin' => 1,
        'role_id' => 1, // executive_manager
    ];
    
    // Check if user exists
    $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$newUser['email']]);
    $userId = $check->fetchColumn();
    
    if (!$userId) {
        // Create new user
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, is_admin, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
        $stmt->execute([$newUser['name'], $newUser['email'], $newUser['password'], $newUser['is_admin']]);
        $userId = $pdo->lastInsertId();
        $status = 'created';
    } else {
        // Update existing user
        $stmt = $pdo->prepare("UPDATE users SET password = ?, is_admin = ? WHERE id = ?");
        $stmt->execute([$newUser['password'], $newUser['is_admin'], $userId]);
        $status = 'updated';
    }
    
    // Assign role
    $roleCheck = $pdo->prepare("SELECT id FROM role_user WHERE user_id = ? AND role_id = ?");
    $roleCheck->execute([$userId, $newUser['role_id']]);
    
    if (!$roleCheck->fetchColumn()) {
        $roleStmt = $pdo->prepare("INSERT INTO role_user (user_id, role_id, created_at, updated_at) VALUES (?, ?, NOW(), NOW())");
        $roleStmt->execute([$userId, $newUser['role_id']]);
    }
    
    // Get role name
    $roleName = $pdo->prepare("SELECT name FROM roles WHERE id = ?");
    $roleName->execute([$newUser['role_id']]);
    $role = $roleName->fetchColumn();
    
    echo json_encode([
        'success' => true,
        'message' => "User {$status} successfully",
        'user' => [
            'id' => $userId,
            'name' => $newUser['name'],
            'email' => $newUser['email'],
            'is_admin' => $newUser['is_admin'],
            'role' => $role,
            'password' => 'password123',
        ],
        'access_url' => 'http://localhost:8000/admin',
    ], JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
    ], JSON_PRETTY_PRINT);
}
?>
