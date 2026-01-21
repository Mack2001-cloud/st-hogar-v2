<?php
require_once __DIR__ . '/../../includes/bootstrap.php';
require_login();

$title = "Mantenimientos";

$q = trim($_GET['q'] ?? '');
$equipo_id = (int)($_GET['equipo_id'] ?? 0);
$estado = trim($_GET['estado'] ?? '');

$equipos = $pdo->query("
  SELECT e.id_equipo, c.nombre AS cliente, e.tipo, e.marca, e.modelo, e.numero_serie
  FROM equipos e
  INNER JOIN clientes c ON c.id_cliente = e.id_cliente
  ORDER BY c.nombre ASC, e.id_equipo DESC
")->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT m.*,
               e.tipo, e.marca, e.modelo, e.numero_serie,
               c.nombre AS cliente,
               s.descripcion AS servicio_desc
        FROM mantenimientos m
        INNER JOIN equipos e ON e.id_equipo = m.id_equipo
        INNER JOIN clientes c ON c.id_cliente = e.id_cliente
        LEFT JOIN servicios s ON s.id_servicio = m.id_servicio
        WHERE 1=1 ";
$params = [];

if ($q !== '') {
  $sql .= " AND (c.nombre LIKE :like OR e.tipo LIKE :like OR e.marca LIKE :like OR e.numero_serie LIKE :like OR m.descripcion LIKE :like) ";
  $params['like'] = "%{$q}%";
}
if ($equipo_id > 0) {
  $sql .= " AND m.id_equipo = :equipo_id ";
  $params['equipo_id'] = $equipo_id;
}
if ($estado !== '') {
  $sql .= " AND m.estado = :estado ";
  $params['estado'] = $estado;
}

$sql .= " ORDER BY m.id_mantenimiento DESC ";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/../../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Mantenimientos</h3>
  <a class="btn btn-primary" href="crear.php">+ Nuevo mantenimiento</a>
</div>

<form class="row g-2 mb-3" method="get">
  <div class="col-md-4">
    <input class="form-control" name="q" value="<?= e($q) ?>" placeholder="Buscar cliente, equipo, serie, descripción...">
  </div>

  <div class="col-md-4">
    <select class="form-select" name="equipo_id">
      <option value="0">Todos los equipos</option>
      <?php foreach($equipos as $eqq): ?>
        <?php
          $label = $eqq['cliente']." | ".$eqq['tipo']." ".($eqq['marca'] ?? '')." ".($eqq['modelo'] ?? '')." | ".$eqq['numero_serie'];
        ?>
        <option value="<?= e((string)$eqq['id_equipo']) ?>" <?= ($equipo_id === (int)$eqq['id_equipo']) ? 'selected' : '' ?>>
          <?= e($label) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-md-2">
    <select class="form-select" name="estado">
      <option value="">Todos</option>
      <?php foreach(['programado','realizado','cancelado'] as $st): ?>
        <option value="<?= e($st) ?>" <?= ($estado === $st) ? 'selected' : '' ?>><?= e($st) ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-md-2 d-grid">
    <button class="btn btn-dark">Filtrar</button>
  </div>
</form>

<div class="card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-striped table-hover mb-0">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Equipo</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th>Próximo</th>
            <th>Costo</th>
            <th class="text-end">Acciones</th>
          </tr>
        </thead>
        <tbody>
        <?php if (!$rows): ?>
          <tr><td colspan="8" class="text-center p-4">Sin registros</td></tr>
        <?php endif; ?>

        <?php foreach($rows as $r): ?>
          <tr>
            <td><?= e((string)$r['id_mantenimiento']) ?></td>
            <td><?= e($r['cliente']) ?></td>
            <td><?= e(trim(($r['tipo'] ?? '')." ".($r['marca'] ?? '')." ".($r['modelo'] ?? ''))) ?><br>
                <small class="text-muted">Serie: <?= e($r['numero_serie'] ?? '') ?></small>
            </td>
            <td><span class="badge bg-secondary"><?= e($r['estado'] ?? '') ?></span></td>
            <td><?= e((string)($r['fecha_mantenimiento'] ?? '')) ?></td>
            <td><?= e((string)($r['proximo_mantenimiento'] ?? '')) ?></td>
            <td>$<?= e(number_format((float)($r['costo'] ?? 0), 2)) ?></td>
            <td class="text-end">
              <a class="btn btn-sm btn-outline-primary" href="editar.php?id=<?= e((string)$r['id_mantenimiento']) ?>">Editar</a>
              <a class="btn btn-sm btn-outline-danger" href="eliminar.php?id=<?= e((string)$r['id_mantenimiento']) ?>">Eliminar</a>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
