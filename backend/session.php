<?php
// ─────────────────────────────────────────────
//  BuyHub — Session Helper
//  backend/session.php
// ─────────────────────────────────────────────
if (session_status() === PHP_SESSION_NONE) session_start();

function isLoggedIn(): bool { return !empty($_SESSION['user_id']); }
function userName(): string  { return htmlspecialchars($_SESSION['user_name'] ?? ''); }
function userEmail(): string { return htmlspecialchars($_SESSION['user_email'] ?? ''); }
function userId(): ?int      { return $_SESSION['user_id'] ?? null; }
?>
