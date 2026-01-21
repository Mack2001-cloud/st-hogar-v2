<?php
// app/modules/ventas/helpers.php

function ventas_validar(array $data): array {
  $errors = [];

  $cliente_id  = (int)($data['cliente_id'] ?? 0);
  $vendedor_id = (int)($data['vendedor_id'] ?? 0);
  $concepto    = trim((string)($data['concepto'] ?? ''));
  $monto_raw   = trim((string)($data['monto'] ?? ''));
  $fecha       = trim((string)($data['fecha'] ?? ''));

  if ($cliente_id <= 0)  $errors[] = 'Selecciona un cliente.';
  if ($vendedor_id <= 0) $errors[] = 'Selecciona un vendedor.';
  if ($concepto === '')  $errors[] = 'El concepto es obligatorio.';

  // monto decimal
  if ($monto_raw === '' || !is_numeric($monto_raw) || (float)$monto_raw <= 0) {
    $errors[] = 'El monto debe ser un número mayor a 0.';
  }

  if ($fecha === '' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
    $errors[] = 'La fecha es obligatoria (formato YYYY-MM-DD).';
  }

  return $errors;
}

function ventas_fetch_clientes(PDO $pdo): array {
  $stmt = $pdo->query("SELECT id, nombre FROM clientes ORDER BY nombre ASC");
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function ventas_fetch_vendedores(PDO $pdo): array {
  $stmt = $pdo->prepare("SELECT id, nombre FROM usuarios WHERE activo = 1 AND rol IN ('ventas','admin') ORDER BY nombre ASC");
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

