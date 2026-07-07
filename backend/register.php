<?php
session_start();
header('Content-Type: application/json');
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']); exit;
}

$name     = trim($_POST['name']     ?? '');
$email    = trim($_POST['email']    ?? '');
$password =      $_POST['password'] ?? '';
$confirm  =      $_POST['confirm']  ?? '';

if (!$name)                                    { echo json_encode(['success'=>false,'message'=>'Full name is required.']); exit; }
if (!filter_var($email, FILTER_VALIDATE_EMAIL)){ echo json_encode(['success'=>false,'message'=>'Enter a valid email address.']); exit; }
if (strlen($password) < 8)                    { echo json_encode(['success'=>false,'message'=>'Password must be at least 8 characters.']); exit; }
if ($password !== $confirm)                   { echo json_encode(['success'=>false,'message'=>'Passwords do not match.']); exit; }

// Check email taken
$chk = $conn->prepare("SELECT id FROM users WHERE email = ?");
$chk->bind_param('s', $email); $chk->execute(); $chk->store_result();
if ($chk->num_rows > 0) { echo json_encode(['success'=>false,'message'=>'This email is already registered.']); $chk->close(); exit; }
$chk->close();

$hash = password_hash($password, PASSWORD_BCRYPT);
$ins  = $conn->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
$ins->bind_param('sss', $name, $email, $hash);

if ($ins->execute()) {
    $_SESSION['user_id']    = $conn->insert_id;
    $_SESSION['user_name']  = $name;
    $_SESSION['user_email'] = $email;
    echo json_encode(['success'=>true,'message'=>'Account created! Welcome to BuyHub.','redirect'=>'../Home.php']);
} else {
    echo json_encode(['success'=>false,'message'=>'Registration failed. Please try again.']);
}
$ins->close(); $conn->close();
?>
