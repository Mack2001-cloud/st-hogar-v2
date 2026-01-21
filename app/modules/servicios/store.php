<?php
// app/modules/servicios/store.php
require_once __DIR__ . '/../../auth/auth_guard.php';
require_login();
require_role(['tecnico','admin']);

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/helpers.php';

$data = [
  'cliente_id' => $_POST['cliente_id'] ?? '',
  'tecnico_id' => $_POST['tecnico_id'] ?? '',
  'descripcion' => $_POST['descripcion'] ?? '',
  'fecha_servicio' => $_POST['fecha_servicio'] ?? '',
  'estado' => $_POST['estado'] ?? '',
];

$errors = servicios_validar($data);
if ($errors) {
  $msg = implode(' ', $errors);
  header('Location: create.php?errors=' . urlencode($msg));
  exit;
}

$stmt = $pdo->prepare("
  INSERT INTO servicios (cliente_id, tecnico_id, descripcion, fecha_servicio, estado)
  VALUES (:cliente_id, :tecnico_id, :descripcion, :fecha_servicio, :estado)
");

$stmt->execute([
  ':cliente_id' => (int)$data['cliente_id'],
  ':tecnico_id' => (int)$data['tecnico_id'],
  ':descripcion' => trim((string)$data['descripcion']),
  ':fecha_servicio' => $data['fecha_servicio'],
  ':estado' => $data['estado'],
]);

header('Location: index.php?ok=1');
exit;

