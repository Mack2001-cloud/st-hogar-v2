<?php
// app/modules/servicios/index.php
require_once __DIR__ . '/../../auth/auth_guard.php';
require_login();
require_role(['tecnico','admin']);

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';

$q = trim((string)($_GET['q'] ?? ''));

$sql = "
SELECT s.id, s.descripcion, s.fecha_servicio, s.estado,
       c.nombre AS cliente,
       u.nombre AS tecnico
FROM servicios s
JOIN clientes c ON c.id = s.cliente_id
JOIN usuarios u ON u.id = s.tecnico_id
WHERE 1=1
";
$params = [];

if ($q !== '') {
  $sql .= " AND (c.nombre LIKE :q OR u.nombre LIKE :q OR s.descripcion LIKE :q) ";
  $params[':q'] = "%$q%";
}

$sql .= " ORDER BY s.fecha_servicio DESC, s.id DESC ";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="content">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Servicios</h2>
    <a href="create.php" class="btn btn-success">+ Nuevo</a>
  </div>

  <?php if (isset($_GET['ok'])): ?>
    <div class="alert alert-success">Acción realizada correctamente.</div>
  <?php endif; ?>

  <form class="mb-3" method="get">
    <div class="input-group">
      <input type="text" name="q" class="form-control" placeholder="Buscar cliente, técnico o descripción..." value="<?= htmlspecialchars($q) ?>">
      <button class="btn btn-outline-secondary" type="submit">Buscar</button>
      <a class="btn btn-outline-secondary" href="index.php">Limpiar</a>
    </div>
  </form>

  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Técnico</th>
            <th>Estado</th>
            <th style="width:220px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
        <?php if (!$rows): ?>
          <tr><td colspan="6" class="text-center text-muted">Sin registros</td></tr>
        <?php endif; ?>

        <?php foreach ($rows as $r): ?>
          <tr>
            <td><?= (int)$r['id'] ?></td>
            <td><?= htmlspecialchars($r['fecha_servicio']) ?></td>
            <td><?= htmlspecialchars($r['cliente']) ?></td>
            <td><?= htmlspecialchars($r['tecnico']) ?></td>
            <td><span class="<?= servicios_estado_badge_class($r['estado']) ?>"><?= htmlspecialchars(str_replace('_',' ', $r['estado'])) ?></span></td>
            <td>
              <a class="btn btn-sm btn-primary" href="edit.php?id=<?= (int)$r['id'] ?>">Editar</a>
              <form action="delete.php" method="post" class="d-inline" onsubmit="return confirm('¿Eliminar este servicio?');">
                <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
