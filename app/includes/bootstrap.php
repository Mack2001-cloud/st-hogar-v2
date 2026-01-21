<?php
// app/includes/bootstrap.ph
require_once __DIR__ . '/../../includes/bootstrap.php';
require_login(); // viene de tu auth.php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/auth.php';

// --- Helpers base ---
function e(string $v): string { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }

function redirect(string $path): void {
  header("Location: {$path}");
  exit;
}

// --- Flash messages ---
function flash_set(string $type, string $msg): void {
  $_SESSION['flash'][] = ['type' => $type, 'msg' => $msg];
}
function flash_get(): array {
  $f = $_SESSION['flash'] ?? [];
  unset($_SESSION['flash']);
  return $f;
}

