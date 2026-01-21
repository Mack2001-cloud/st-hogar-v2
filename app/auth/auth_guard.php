<?php
declare(strict_types=1);

/**
 * Guard y utilidades de autenticación/roles para ST-HOGAR
 * Requiere: app/config/auth.php
 */

require_once __DIR__ . '/../config/auth.php';

function start_app_session(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_name(AUTH_SESSION_NAME);
        // Ajusta estas banderas si ya estás en HTTPS:
        session_set_cookie_params([
            'lifetime' => 0,
            'path'     => '/',
            'httponly' => true,
            'samesite' => 'Lax',
            'secure'   => AUTH_COOKIE_SECURE,
        ]);
        session_start();
    }
}

function is_logged_in(): bool {
    start_app_session();
    return !empty($_SESSION['user']);
}

function require_login(): void {
    if (!is_logged_in()) {
        header('Location: ' . AUTH_LOGIN_PATH);
        exit;
    }
}

function current_user(): ?array {
    start_app_session();
    return $_SESSION['user'] ?? null;
}

function require_role(array $allowed): void {
    require_login();
    $user = current_user();
    $role = $user['rol'] ?? '';
    if (!in_array($role, $allowed, true)) {
        http_response_code(403);
        include __DIR__ . '/../includes/403.php';
        exit;
    }
}

/** Flash messages */
function flash_set(string $key, string $msg): void {
    start_app_session();
    $_SESSION['_flash'][$key] = $msg;
}
function flash_get(string $key): ?string {
    start_app_session();
    if (!isset($_SESSION['_flash'][$key])) return null;
    $msg = (string)$_SESSION['_flash'][$key];
    unset($_SESSION['_flash'][$key]);
    return $msg;
}

/** Helpers */
function e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
