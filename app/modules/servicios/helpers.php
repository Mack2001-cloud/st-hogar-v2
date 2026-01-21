<?php
// app/modules/servicios/helpers.php

function servicios_estados(): array {
  return ['pendiente', 'en_proceso', 'finalizado'];
}

function servicios_estado_badge_class(string $estado): string {
  return match ($estado) {
    'pendiente'  => 'badge bg-warning text-dark',
    'en_proceso' => 'badge bg-info text-dark',
    'finalizado' => 'badge bg-success',
    default      => 'badge bg-secondary',
  };
}

function servicios_validar(array $data): array {
  $errors = [];

  $cliente_id   = (int)($data['cliente_id'] ?? 0);
  $tecnico_id   = (int)($data['tecnico_id'] ?? 0);
  $descripcion  = trim((string)($data['descripcion'] ?? ''));
  $fecha        = trim((string)($data['fecha_servicio'] ?? ''));
  $estado       = trim((string)($data['estado'] ?? ''));

  if ($cliente_id <= 0) $errors[] = 'Selecciona un cliente.';
  if ($tecnico_id <= 0) $errors[] = 'Selecciona un técnico.';
  if ($descripcion === '') $errors[] = 'La descripción es obligatoria.';

  // Validación simple de fecha YYYY-MM-DD
  if ($fecha === '' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
    $errors[] = 'La fecha del servicio es obligatoria (formato YYYY-MM-DD).';
  }

  if (!in_array($estado, servicios_estados(), true)) {
    $errors[] = 'Selecciona un estado válido.';
  }

  return $errors;
}

function servicios_fetch_clientes(PDO $pdo): array {
  $stmt = $pdo->query("SELECT id, nombre FROM clientes ORDER BY nombre ASC");
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function servicios_fetch_tecnicos(PDO $pdo): array {
  $stmt = $pdo->prepare("SELECT id, nombre FROM usuarios WHERE activo = 1 AND rol IN ('tecnico','admin') ORDER BY nombre ASC");
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
