<?php
require_once __DIR__ . '/../../includes/bootstrap.php';
require_login();
csrf_verify();

$id = (int)($_POST['id_venta'] ?? 0);

if ($id <= 0) {
  flash_set('danger', 'ID inválido.');
  redirect('index.php');
}

$stmt = $pdo->prepare("DELETE FROM ventas WHERE id_venta=:id");
$stmt->execute(['id' => $id]);

flash_set('success', 'Venta eliminada.');
redirect('index.php');
