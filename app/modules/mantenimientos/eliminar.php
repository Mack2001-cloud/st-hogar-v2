<?php
require_once __DIR__ . '/../../includes/bootstrap.php';
require_login();

$title = "Eliminar mantenimiento";
$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("
  SELECT m.id_mantenimiento, m.descripcion, m.estado,
         c.nombre AS cliente, e.tipo, e.marca, e.modelo, e.numero_serie
  FROM mantenimientos m
  INNER JOIN equipos e ON e.id_equipo=m.id_equipo
  INNER JOIN clientes c ON c.id_cliente=e.id_cliente
  WHERE m.id_mantenimiento=:id
");
$stmt->execute(['id' => $id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
  flash_set('danger', 'Mantenimiento no encontrado.');
  redirect('index.php');
}

require_once __DIR__ . '/../../includes/header.php';
?>

<h3 class="mb-3">Eliminar mantenimiento</h3>

<div class="card p-4">
  <p>¿Seguro que deseas eliminar el mantenimiento <strong>#<?= e((string)$row['id_mantenimiento']) ?></strong>?</p>
  <p class="mb-3">
    <strong>Cliente:</strong> <?= e($row['cliente']) ?><br>
    <strong>Equipo:</strong> <?= e(trim(($row['tipo'] ?? '')." ".($row['marca'] ?? '')." ".($row['modelo'] ?? ''))) ?>
    (Serie: <?= e($row['numero_serie'] ?? '') ?>)<br>
    <strong>Estado:</strong> <?= e($row['estado']) ?><br>
    <strong>Descripción:</strong> <?= e($row['descripcion']) ?>
  </p>

  <form method="post" action="destroy.php" class="d-flex gap-2">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
    <input type="hidden" name="id_mantenimiento" value="<?= e((string)$row['id_mantenimiento']) ?>">
    <button class="btn btn-danger">Sí, eliminar</button>
    <a class="btn btn-outline-secondary" href="index.php">Cancelar</a>
  </form>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
