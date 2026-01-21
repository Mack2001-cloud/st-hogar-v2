
<?php
require_once __DIR__ . '/../../includes/bootstrap.php';
require_login();

$title = "Nuevo equipo";

$clientes = $pdo->query("SELECT id_cliente, nombre FROM clientes ORDER BY nombre ASC")->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/../../includes/header.php';
?>

<h3 class="mb-3">Registrar equipo</h3>

<form class="card p-4" method="post" action="store.php">
  <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Cliente</label>
      <select class="form-select" name="id_cliente" required>
        <option value="">-- Selecciona --</option>
        <?php foreach($clientes as $c): ?>
          <option value="<?= e((string)$c['id_cliente']) ?>"><?= e($c['nombre']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">Tipo</label>
      <input class="form-control" name="tipo" required placeholder="Cámara / DVR / Alarma / Router / etc">
    </div>

    <div class="col-md-4">
      <label class="form-label">Marca</label>
      <input class="form-control" name="marca">
    </div>
    <div class="col-md-4">
      <label class="form-label">Modelo</label>
      <input class="form-control" name="modelo">
    </div>
    <div class="col-md-4">
      <label class="form-label">Número de serie</label>
      <input class="form-control" name="numero_serie">
    </div>

    <div class="col-md-8">
      <label class="form-label">Descripción</label>
      <input class="form-control" name="descripcion">
    </div>

    <div class="col-md-4">
      <label class="form-label">Estado</label>
      <select class="form-select" name="estado">
        <option value="activo">activo</option>
        <option value="mantenimiento">mantenimiento</option>
        <option value="baja">baja</option>
      </select>
    </div>

    <div class="col-12 d-flex gap-2">
      <button class="btn btn-primary">Guardar</button>
      <a class="btn btn-outline-secondary" href="index.php">Cancelar</a>
    </div>
  </div>
</form>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>