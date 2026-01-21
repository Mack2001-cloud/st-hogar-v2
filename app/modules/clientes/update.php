<?php
declare(strict_types=1);

require_once __DIR__ . '/../../auth/auth_guard.php';
require_login();
require_role(['ventas','admin']);

$pdo = require __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ./index.php');
    exit;
}

$id = (int)($_POST['id_cliente'] ?? 0);

$data = [
  'nombre'    => trim((string)($_POST['nombre'] ?? '')),
  'telefono'  => trim((string)($_POST['telefono'] ?? '')),
  'email'     => trim((string)($_POST['email'] ?? '')),
  'direccion' => trim((string)($_POST['direccion'] ?? '')),
];

if ($id <= 0) {
    header('Location: ./index.php');
    exit;
}

clientes_update($pdo, $id, $data);
flash_set('ok', 'Cliente actualizado correctamente.');
header('Location: ./index.php');
exit;
