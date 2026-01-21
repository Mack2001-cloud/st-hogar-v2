<?php
require_once __DIR__ . '/../../includes/bootstrap.php';
require_login();

$title = "Editar equipo";
$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM equipos WHERE id_equipo = :id");
$stmt->execute(['id' => $id]);
$equipo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$equipo) {
  flash_set('danger', 'Equipo no encontrado.');
  redirect('index.php');
}

$clientes = $pdo->query("SELECT id_cliente, nombre FROM clientes ORDER BY nombre ASC")->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/../../includes/header.php';
?>

<h3 class="mb-3">Editar equipo #<?= e((string)$equipo['id_equipo']) ?></h3>

<form class="card p-4" method="post" action="update.php">
  <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
  <input type="hidden" name="id_equipo" value="<?= e((string)$equipo['id_equipo']) ?>">

  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Cliente</label>
      <select class="form-select" name="id_cliente" required>
        <?php foreach($clientes as $c): ?>
          <option value="<?= e((string)$c['id_cliente']) ?>"
            <?= ((int)$equipo['id_cliente'] === (int)$c['id_cliente']) ? 'selected' : '' ?>>
            <?= e($c['nombre']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">Tipo</label>
      <input class="form-control" name="tipo" required value="<?= e($equipo['tipo']) ?>">
    </div>

    <div class="col-md-4">
      <label class="form-label">Marca</label>
      <input class="form-control" name="marca" value="<?= e($equipo['marca'] ?? '') ?>">
    </div>
    <div class="col-md-4">
      <label class="form-label">Modelo</label>
      <input class="form-control" name="modelo" value="<?= e($equipo['modelo'] ?? '') ?>">
    </div>
    <div class="col-md-4">
      <label class="form-label">Número de serie</label>
      <input class="form-control" name="numero_serie" value="<?= e($equipo['numero_serie'] ?? '') ?>">
    </div>

    <div class="col-md-8">
      <label class="form-label">Descripción</label>
      <input class="form-control" name="descripcion" value="<?= e($equipo['descripcion'] ?? '') ?>">
    </div>

    <div class="col-md-4">
      <label class="form-label">Estado</label>
      <select class="form-select" name="estado">
        <?php foreach(['activo','mantenimiento','baja'] as $st): ?>
          <option value="<?= e($st) ?>" <?= ($equipo['estado'] === $st) ? 'selected' : '' ?>><?= e($st) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-12 d-flex gap-2">
      <button class="btn btn-primary">Actualizar</button>
      <a class="btn btn-outline-secondary" href="index.php">Cancelar</a>
    </div>
  </div>
</form>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
