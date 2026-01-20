<?php
/**
 * Set test users as admins
 * Access at: http://localhost:8000/make_admins.php
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
    
    $testEmails = ['executive@example.com', 'consultant@example.com', 'admin@example.com'];
    
    // Update all test users to be admins
    $stmt = $pdo->prepare("UPDATE users SET is_admin = 1 WHERE email = ?");
    
    foreach ($testEmails as $email) {
        $stmt->execute([$email]);
    }
    
    // Verify
    $result = $pdo->prepare("SELECT id, name, email, is_admin FROM users WHERE email IN ('executive@example.com', 'consultant@example.com', 'admin@example.com')");
    $result->execute();
    $verified = $result->fetchAll();
    
    echo json_encode([
        'success' => true,
        'message' => 'Test users updated to admins',
        'users' => $verified,
    ], JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
    ], JSON_PRETTY_PRINT);
}
?>
