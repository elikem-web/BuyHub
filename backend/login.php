<?php
session_start();
header('Content-Type: application/json');
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']); exit;
}

$email    = trim($_POST['email']    ?? '');
$password =      $_POST['password'] ?? '';

if (!$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'Email and password are required.']); exit;
}

$stmt = $conn->prepare("SELECT id, name, email, password_hash FROM users WHERE email = ?");
$stmt->bind_param('s', $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user || !password_verify($password, $user['password_hash'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid email or password.']); exit;
}

$_SESSION['user_id']    = $user['id'];
$_SESSION['user_name']  = $user['name'];
$_SESSION['user_email'] = $user['email'];

echo json_encode([
    'success'  => true,
    'message'  => 'Welcome back, ' . htmlspecialchars($user['name']) . '!',
    'redirect' => '../Home.php'
]);
$conn->close();
?>
