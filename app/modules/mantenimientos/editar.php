<?php
require_once __DIR__ . '/../../includes/bootstrap.php';
require_login();

$title = "Editar mantenimiento";
$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM mantenimientos WHERE id_mantenimiento=:id");
$stmt->execute(['id' => $id]);
$m = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$m) {
  flash_set('danger', 'Mantenimiento no encontrado.');
  redirect('index.php');
}

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

<h3 class="mb-3">Editar mantenimiento #<?= e((string)$m['id_mantenimiento']) ?></h3>

<form class="card p-4" method="post" action="update.php">
  <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
  <input type="hidden" name="id_mantenimiento" value="<?= e((string)$m['id_mantenimiento']) ?>">

  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Equipo</label>
      <select class="form-select" name="id_equipo" required>
        <?php foreach($equipos as $eq): ?>
          <?php $label = $eq['cliente']." | ".$eq['tipo']." ".($eq['marca'] ?? '')." ".($eq['modelo'] ?? '')." | ".$eq['numero_serie']; ?>
          <option value="<?= e((string)$eq['id_equipo']) ?>" <?= ((int)$m['id_equipo'] === (int)$eq['id_equipo']) ? 'selected' : '' ?>>
            <?= e($label) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">Servicio relacionado (opcional)</label>
      <select class="form-select" name="id_servicio">
        <option value="">Sin servicio</option>
        <?php foreach($servicios as $s): ?>
          <option value="<?= e((string)$s['id_servicio']) ?>" <?= ((int)($m['id_servicio'] ?? 0) === (int)$s['id_servicio']) ? 'selected' : '' ?>>
            #<?= e((string)$s['id_servicio']) ?> | <?= e($s['cliente']) ?> | <?= e($s['estado']) ?> | <?= e(mb_strimwidth($s['descripcion'], 0, 40, '...')) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-8">
      <label class="form-label">Descripción</label>
      <input class="form-control" name="descripcion" required value="<?= e($m['descripcion']) ?>">
    </div>

    <div class="col-md-4">
      <label class="form-label">Estado</label>
      <select class="form-select" name="estado" required>
        <?php foreach(['programado','realizado','cancelado'] as $st): ?>
          <option value="<?= e($st) ?>" <?= ($m['estado'] === $st) ? 'selected' : '' ?>><?= e($st) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-4">
      <label class="form-label">Costo</label>
      <input class="form-control" name="costo" type="number" step="0.01" min="0" value="<?= e((string)($m['costo'] ?? 0)) ?>">
    </div>

    <div class="col-md-4">
      <label class="form-label">Fecha mantenimiento</label>
      <input class="form-control" name="fecha_mantenimiento" type="date" value="<?= e($m['fecha_mantenimiento'] ?? '') ?>">
    </div>

    <div class="col-md-4">
      <label class="form-label">Próximo mantenimiento</label>
      <input class="form-control" name="proximo_mantenimiento" type="date" value="<?= e($m['proximo_mantenimiento'] ?? '') ?>">
    </div>

    <div class="col-12 d-flex gap-2">
      <button class="btn btn-primary">Actualizar</button>
      <a class="btn btn-outline-secondary" href="index.php">Cancelar</a>
    </div>
  </div>
</form>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
