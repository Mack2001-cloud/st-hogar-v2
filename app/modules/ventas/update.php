<?php
// app/modules/ventas/update.php
require_once __DIR__ . '/../../auth/auth_guard.php';
require_login();
require_role(['ventas','admin']);

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/helpers.php';

$id = (int)($_POST['id'] ?? 0);
if ($id <= 0) { header('Location: index.php'); exit; }

$data = [
  'cliente_id'  => $_POST['cliente_id'] ?? '',
  'vendedor_id' => $_POST['vendedor_id'] ?? '',
  'concepto'    => $_POST['concepto'] ?? '',
  'monto'       => $_POST['monto'] ?? '',
  'fecha'       => $_POST['fecha'] ?? '',
];

$errors = ventas_validar($data);
if ($errors) {
  header('Location: edit.php?id=' . $id . '&errors=' . urlencode(implode(' ', $errors)));
  exit;
}

$stmt = $pdo->prepare("
  UPDATE ventas
  SET cliente_id = :cliente_id,
      vendedor_id = :vendedor_id,
      concepto = :concepto,
      monto = :monto,
      fecha = :fecha
  WHERE id = :id
");

$stmt->execute([
  ':cliente_id'  => (int)$data['cliente_id'],
  ':vendedor_id' => (int)$data['vendedor_id'],
  ':concepto'    => trim((string)$data['concepto']),
  ':monto'       => (float)$data['monto'],
  ':fecha'       => $data['fecha'],
  ':id'          => $id,
]);

header('Location: index.php?ok=1');
exit;
