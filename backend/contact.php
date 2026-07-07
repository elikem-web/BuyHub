<?php
session_start();
header('Content-Type: application/json');
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success'=>false,'message'=>'Method not allowed.']); exit;
}

$name    = trim($_POST['name']    ?? '');
$email   = trim($_POST['email']   ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if (!$name)                                    { echo json_encode(['success'=>false,'message'=>'Name is required.']); exit; }
if (!filter_var($email, FILTER_VALIDATE_EMAIL)){ echo json_encode(['success'=>false,'message'=>'Valid email required.']); exit; }
if (!$subject)                                 { echo json_encode(['success'=>false,'message'=>'Please select a subject.']); exit; }
if (strlen($message) < 10)                    { echo json_encode(['success'=>false,'message'=>'Message is too short.']); exit; }

$uid  = $_SESSION['user_id'] ?? null;
$stmt = $conn->prepare("INSERT INTO contact_messages (user_id, name, email, subject, message) VALUES (?,?,?,?,?)");
$stmt->bind_param('issss', $uid, $name, $email, $subject, $message);

if ($stmt->execute()) {
    echo json_encode(['success'=>true,'message'=>"Thanks, $name! We'll get back to you within 24 hours."]);
} else {
    echo json_encode(['success'=>false,'message'=>'Failed to send. Please try again.']);
}
$stmt->close(); $conn->close();
?>
