<?php
// app/modules/servicios/update.php
require_once __DIR__ . '/../../auth/auth_guard.php';
require_login();
require_role(['tecnico','admin']);

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/helpers.php';

$id = (int)($_POST['id'] ?? 0);
if ($id <= 0) {
  header('Location: index.php');
  exit;
}

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
  header('Location: edit.php?id=' . $id . '&errors=' . urlencode($msg));
  exit;
}

$stmt = $pdo->prepare("
  UPDATE servicios
  SET cliente_id = :cliente_id,
      tecnico_id = :tecnico_id,
      descripcion = :descripcion,
      fecha_servicio = :fecha_servicio,
      estado = :estado
  WHERE id = :id
");

$stmt->execute([
  ':cliente_id' => (int)$data['cliente_id'],
  ':tecnico_id' => (int)$data['tecnico_id'],
  ':descripcion' => trim((string)$data['descripcion']),
  ':fecha_servicio' => $data['fecha_servicio'],
  ':estado' => $data['estado'],
  ':id' => $id,
]);

header('Location: index.php?ok=1');
exit;
