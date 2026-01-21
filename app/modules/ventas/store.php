<?php
// app/modules/ventas/store.php
require_once __DIR__ . '/../../auth/auth_guard.php';
require_login();
require_role(['ventas','admin']);

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/helpers.php';

$data = [
  'cliente_id'  => $_POST['cliente_id'] ?? '',
  'vendedor_id' => $_POST['vendedor_id'] ?? '',
  'concepto'    => $_POST['concepto'] ?? '',
  'monto'       => $_POST['monto'] ?? '',
  'fecha'       => $_POST['fecha'] ?? '',
];

$errors = ventas_validar($data);
if ($errors) {
  header('Location: create.php?errors=' . urlencode(implode(' ', $errors)));
  exit;
}

$stmt = $pdo->prepare("
  INSERT INTO ventas (cliente_id, vendedor_id, concepto, monto, fecha)
  VALUES (:cliente_id, :vendedor_id, :concepto, :monto, :fecha)
");

$stmt->execute([
  ':cliente_id'  => (int)$data['cliente_id'],
  ':vendedor_id' => (int)$data['vendedor_id'],
  ':concepto'    => trim((string)$data['concepto']),
  ':monto'       => (float)$data['monto'],
  ':fecha'       => $data['fecha'],
]);

header('Location: index.php?ok=1');
exit;
