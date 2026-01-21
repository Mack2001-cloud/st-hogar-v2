<?php
require_once __DIR__ . '/../../includes/bootstrap.php';
require_login();
csrf_verify();

$id_cliente   = (int)($_POST['id_cliente'] ?? 0);
$tipo         = trim($_POST['tipo'] ?? '');
$marca        = trim($_POST['marca'] ?? '');
$modelo       = trim($_POST['modelo'] ?? '');
$numero_serie = trim($_POST['numero_serie'] ?? '');
$descripcion  = trim($_POST['descripcion'] ?? '');
$estado       = trim($_POST['estado'] ?? 'activo');

if ($id_cliente <= 0 || $tipo === '') {
  flash_set('danger', 'Cliente y Tipo son obligatorios.');
  redirect('crear.php');
}

$sql = "INSERT INTO equipos (id_cliente, tipo, marca, modelo, numero_serie, descripcion, estado)
        VALUES (:id_cliente, :tipo, :marca, :modelo, :numero_serie, :descripcion, :estado)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
  'id_cliente' => $id_cliente,
  'tipo' => $tipo,
  'marca' => $marca,
  'modelo' => $modelo,
  'numero_serie' => $numero_serie,
  'descripcion' => $descripcion,
  'estado' => $estado
]);

flash_set('success', 'Equipo registrado.');
redirect('index.php');
