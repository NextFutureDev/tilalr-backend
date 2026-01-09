<?php
// Direct test user creation with proper database connection
$host = '127.0.0.1';
$db = 'tilalrimal';
$user = 'root';
$pass = '';

try {
    // PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    
    // Test users data
    $testUsers = [
        ['name' => 'Executive Manager', 'email' => 'executive@example.com', 'password' => password_hash('password123', PASSWORD_BCRYPT), 'role_id' => 1],
        ['name' => 'Consultant', 'email' => 'consultant@example.com', 'password' => password_hash('password123', PASSWORD_BCRYPT), 'role_id' => 2],
        ['name' => 'Administration', 'email' => 'admin@example.com', 'password' => password_hash('password123', PASSWORD_BCRYPT), 'role_id' => 3],
    ];
    
    echo "================================\n";
    echo "CREATING TEST USERS\n";
    echo "================================\n\n";
    
    foreach ($testUsers as $testUser) {
        // Check if user exists
        $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$testUser['email']]);
        $existing = $check->fetchColumn();
        
        if ($existing) {
            echo "⚠ User already exists: {$testUser['email']} (ID: $existing)\n";
            $userId = $existing;
        } else {
            // Insert new user
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, is_admin, created_at, updated_at) VALUES (?, ?, ?, 0, NOW(), NOW())");
            $stmt->execute([$testUser['name'], $testUser['email'], $testUser['password']]);
            $userId = $pdo->lastInsertId();
            echo "✓ Created user: {$testUser['name']} (ID: $userId)\n";
        }
        
        // Assign role
        $roleCheck = $pdo->prepare("SELECT id FROM role_user WHERE user_id = ? AND role_id = ?");
        $roleCheck->execute([$userId, $testUser['role_id']]);
        
        if (!$roleCheck->fetchColumn()) {
            $roleStmt = $pdo->prepare("INSERT INTO role_user (user_id, role_id, created_at, updated_at) VALUES (?, ?, NOW(), NOW())");
            $roleStmt->execute([$userId, $testUser['role_id']]);
            echo "  → Assigned role ID: {$testUser['role_id']}\n";
        }
        
        // Get role name
        $roleName = $pdo->prepare("SELECT name FROM roles WHERE id = ?");
        $roleName->execute([$testUser['role_id']]);
        $name = $roleName->fetchColumn();
        echo "  → Role: $name\n\n";
    }
    
    // Verify creation
    echo "================================\n";
    echo "VERIFICATION\n";
    echo "================================\n\n";
    
    $result = $pdo->query("SELECT u.id, u.name, u.email, r.name as role_name FROM users u LEFT JOIN role_user ru ON u.id = ru.user_id LEFT JOIN roles r ON ru.role_id = r.id WHERE u.email IN ('executive@example.com', 'consultant@example.com', 'admin@example.com')");
    
    while ($row = $result->fetch()) {
        echo "✓ {$row['name']} ({$row['email']}) → {$row['role_name']}\n";
    }
    
    echo "\n✓ All test users created successfully!\n";
    
} catch (PDOException $e) {
    echo "✗ Database Error: " . $e->getMessage() . "\n";
    die(1);
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    die(1);
}
?>
