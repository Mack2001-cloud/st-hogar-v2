<?php
declare(strict_types=1);

require_once __DIR__ . '/auth_guard.php';
$pdo = require __DIR__ . '/../config/db.php';

start_app_session();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . AUTH_LOGIN_PATH);
    exit;
}

$identifier = trim((string)($_POST['identifier'] ?? ''));
$password   = (string)($_POST['password'] ?? '');

if ($identifier === '' || $password === '') {
    flash_set('error', 'Completa usuario/correo y contraseña.');
    header('Location: ' . AUTH_LOGIN_PATH);
    exit;
}

$sql = <<<SQL
SELECT id, nombre, usuario, email, password_hash, rol, activo
FROM usuarios
WHERE (email = :identifier OR usuario = :identifier)
LIMIT 1
SQL;

$stmt = $pdo->prepare($sql);
$stmt->execute(['identifier' => $identifier]);
$user = $stmt->fetch();

if (!$user || (int)$user['activo'] !== 1) {
    flash_set('error', 'Credenciales inválidas o usuario inactivo.');
    header('Location: ' . AUTH_LOGIN_PATH);
    exit;
}

if (!password_verify($password, (string)$user['password_hash'])) {
    flash_set('error', 'Credenciales inválidas.');
    header('Location: ' . AUTH_LOGIN_PATH);
    exit;
}

// Login OK
session_regenerate_id(true);
$_SESSION['user'] = [
    'id'      => (int)$user['id'],
    'nombre'  => (string)$user['nombre'],
    'usuario' => (string)$user['usuario'],
    'email'   => (string)($user['email'] ?? ''),
    'rol'     => (string)$user['rol'],
];

header('Location: ' . AUTH_HOME_PATH);
exit;

