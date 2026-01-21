<?php
require_once __DIR__ . '/../../includes/bootstrap.php';
require_login();
csrf_verify();

$id_equipo    = (int)($_POST['id_equipo'] ?? 0);
$id_cliente   = (int)($_POST['id_cliente'] ?? 0);
$tipo         = trim($_POST['tipo'] ?? '');
$marca        = trim($_POST['marca'] ?? '');
$modelo       = trim($_POST['modelo'] ?? '');
$numero_serie = trim($_POST['numero_serie'] ?? '');
$descripcion  = trim($_POST['descripcion'] ?? '');
$estado       = trim($_POST['estado'] ?? 'activo');

if ($id_equipo <= 0 || $id_cliente <= 0 || $tipo === '') {
  flash_set('danger', 'Datos inválidos.');
  redirect('index.php');
}

$sql = "UPDATE equipos
        SET id_cliente=:id_cliente, tipo=:tipo, marca=:marca, modelo=:modelo,
            numero_serie=:numero_serie, descripcion=:descripcion, estado=:estado
        WHERE id_equipo=:id_equipo";
$stmt = $pdo->prepare($sql);
$stmt->execute([
  'id_cliente' => $id_cliente,
  'tipo' => $tipo,
  'marca' => $marca,
  'modelo' => $modelo,
  'numero_serie' => $numero_serie,
  'descripcion' => $descripcion,
  'estado' => $estado,
  'id_equipo' => $id_equipo
]);

flash_set('success', 'Equipo actualizado.');
redirect('index.php');
