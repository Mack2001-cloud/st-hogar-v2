<?php
require_once __DIR__ . '/../../includes/bootstrap.php';
require_login();

$title = "Eliminar equipo";
$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT e.id_equipo, c.nombre AS cliente, e.tipo
                       FROM equipos e INNER JOIN clientes c ON c.id_cliente=e.id_cliente
                       WHERE e.id_equipo=:id");
$stmt->execute(['id' => $id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
  flash_set('danger', 'Equipo no encontrado.');
  redirect('index.php');
}

require_once __DIR__ . '/../../includes/header.php';
?>

<h3 class="mb-3">Eliminar equipo</h3>

<div class="card p-4">
  <p>¿Seguro que deseas eliminar el equipo <strong>#<?= e((string)$row['id_equipo']) ?></strong>
  del cliente <strong><?= e($row['cliente']) ?></strong> (<?= e($row['tipo']) ?>)?</p>

  <form method="post" action="destroy.php" class="d-flex gap-2">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
    <input type="hidden" name="id_equipo" value="<?= e((string)$row['id_equipo']) ?>">
    <button class="btn btn-danger">Sí, eliminar</button>
    <a class="btn btn-outline-secondary" href="index.php">Cancelar</a>
  </form>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
