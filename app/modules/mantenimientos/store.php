<?php
require_once __DIR__ . '/../../includes/bootstrap.php';
require_login();
csrf_verify();

$id_equipo = (int)($_POST['id_equipo'] ?? 0);
$id_servicio = (int)($_POST['id_servicio'] ?? 0);
$descripcion = trim($_POST['descripcion'] ?? '');
$estado = trim($_POST['estado'] ?? 'programado');
$costo = (float)($_POST['costo'] ?? 0);

$fecha_mantenimiento = trim($_POST['fecha_mantenimiento'] ?? '');
$proximo_mantenimiento = trim($_POST['proximo_mantenimiento'] ?? '');

$estados_validos = ['programado','realizado','cancelado'];

if ($id_equipo <= 0 || $descripcion === '' || !in_array($estado, $estados_validos, true)) {
  flash_set('danger', 'Datos inválidos. Verifica Equipo, Descripción y Estado.');
  redirect('crear.php');
}

if ($fecha_mantenimiento === '') $fecha_mantenimiento = date('Y-m-d');
if ($proximo_mantenimiento === '') $proximo_mantenimiento = null;

$sql = "INSERT INTO mantenimientos (id_equipo, id_servicio, descripcion, costo, fecha_mantenimiento, proximo_mantenimiento, estado)
        VALUES (:id_equipo, :id_servicio, :descripcion, :costo, :fecha_mantenimiento, :proximo_mantenimiento, :estado)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
  'id_equipo' => $id_equipo,
  'id_servicio' => ($id_servicio > 0 ? $id_servicio : null),
  'descripcion' => $descripcion,
  'costo' => $costo,
  'fecha_mantenimiento' => $fecha_mantenimiento,
  'proximo_mantenimiento' => $proximo_mantenimiento,
  'estado' => $estado,
]);

flash_set('success', 'Mantenimiento registrado.');
redirect('index.php');
