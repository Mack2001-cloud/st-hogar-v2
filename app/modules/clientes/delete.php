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
if ($id > 0) {
    clientes_delete($pdo, $id);
    flash_set('ok', 'Cliente eliminado correctamente.');
}

header('Location: ./index.php');
exit;
