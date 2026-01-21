<?php
require_once __DIR__ . '/../../includes/bootstrap.php';
require_login();

$title = "Nuevo mantenimiento";

$equipos = $pdo->query("
  SELECT e.id_equipo, c.nombre AS cliente, e.tipo, e.marca, e.modelo, e.numero_serie
  FROM equipos e
  INNER JOIN clientes c ON c.id_cliente = e.id_cliente
  ORDER BY c.nombre ASC, e.id_equipo DESC
")->fetchAll(PDO::FETCH_ASSOC);

$servicios = $pdo->query("
  SELECT s.id_servicio, c.nombre AS cliente, s.estado, s.descripcion
  FROM servicios s
  INNER JOIN clientes c ON c.id_cliente = s.id_cliente
  ORDER BY s.id_servicio DESC
")->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/../../includes/header.php';
?>

<h3 class="mb-3">Registrar mantenimiento</h3>

<form class="card p-4" method="post" action="store.php">
  <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Equipo</label>
      <select class="form-select" name="id_equipo" required>
        <option value="">-- Selecciona --</option>
        <?php foreach($equipos as $eq): ?>
          <?php $label = $eq['cliente']." | ".$eq['tipo']." ".($eq['marca'] ?? '')." ".($eq['modelo'] ?? '')." | ".$eq['numero_serie']; ?>
          <option value="<?= e((string)$eq['id_equipo']) ?>"><?= e($label) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">Servicio relacionado (opcional)</label>
      <select class="form-select" name="id_servicio">
        <option value="">Sin servicio</option>
        <?php foreach($servicios as $s): ?>
          <option value="<?= e((string)$s['id_servicio']) ?>">
            #<?= e((string)$s['id_servicio']) ?> | <?= e($s['cliente']) ?> | <?= e($s['estado']) ?> | <?= e(mb_strimwidth($s['descripcion'], 0, 40, '...')) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-8">
      <label class="form-label">Descripción</label>
      <input class="form-control" name="descripcion" required placeholder="Cambio de fuente, limpieza, revisión DVR, etc">
    </div>

    <div class="col-md-4">
      <label class="form-label">Estado</label>
      <select class="form-select" name="estado" required>
        <option value="programado">programado</option>
        <option value="realizado">realizado</option>
        <option value="cancelado">cancelado</option>
      </select>
    </div>

    <div class="col-md-4">
      <label class="form-label">Costo</label>
      <input class="form-control" name="costo" type="number" step="0.01" min="0" placeholder="0.00">
    </div>

    <div class="col-md-4">
      <label class="form-label">Fecha mantenimiento</label>
      <input class="form-control" name="fecha_mantenimiento" type="date">
      <div class="form-text">Si lo dejas vacío se toma hoy.</div>
    </div>

    <div class="col-md-4">
      <label class="form-label">Próximo mantenimiento</label>
      <input class="form-control" name="proximo_mantenimiento" type="date">
    </div>

    <div class="col-12 d-flex gap-2">
      <button class="btn btn-primary">Guardar</button>
      <a class="btn btn-outline-secondary" href="index.php">Cancelar</a>
    </div>
  </div>
</form>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
