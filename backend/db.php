<?php
// ─────────────────────────────────────────────
//  BuyHub — Database Connection
//  backend/db.php
// ─────────────────────────────────────────────
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');        // your MySQL password here if you set one
define('DB_NAME', 'buyhub'); // change to buyhub_db if that's yours

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    http_response_code(500);
    die(json_encode([
        'success' => false,
        'message' => 'Database connection failed: ' . $conn->connect_error
    ]));
}

$conn->set_charset('utf8mb4');
?>
