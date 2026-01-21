<?php
// app/modules/ventas/index.php
require_once __DIR__ . '/../../auth/auth_guard.php';
require_login();
require_role(['ventas','admin']);

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';

$q = trim((string)($_GET['q'] ?? ''));

$sql = "
SELECT v.id, v.concepto, v.monto, v.fecha,
       c.nombre AS cliente,
       u.nombre AS vendedor
FROM ventas v
JOIN clientes c ON c.id = v.cliente_id
JOIN usuarios u ON u.id = v.vendedor_id
WHERE 1=1
";
$params = [];

if ($q !== '') {
  $sql .= " AND (c.nombre LIKE :q OR u.nombre LIKE :q OR v.concepto LIKE :q) ";
  $params[':q'] = "%$q%";
}

$sql .= " ORDER BY v.fecha DESC, v.id DESC ";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// total rápido (opcional)
$total = 0.0;
foreach ($rows as $r) $total += (float)$r['monto'];
?>
<div class="content">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Ventas</h2>
    <a href="create.php" class="btn btn-success">+ Nueva</a>
  </div>

  <?php if (isset($_GET['ok'])): ?>
    <div class="alert alert-success">Acción realizada correctamente.</div>
  <?php endif; ?>

  <form class="mb-3" method="get">
    <div class="input-group">
      <input type="text" name="q" class="form-control" placeholder="Buscar cliente, vendedor o concepto..." value="<?= htmlspecialchars($q) ?>">
      <button class="btn btn-outline-secondary" type="submit">Buscar</button>
      <a class="btn btn-outline-secondary" href="index.php">Limpiar</a>
    </div>
  </form>

  <div class="card mb-3">
    <div class="card-body">
      <strong>Total (resultados actuales):</strong>
      $<?= number_format($total, 2) ?>
    </div>
  </div>

  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Vendedor</th>
            <th>Concepto</th>
            <th>Monto</th>
            <th style="width:220px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
        <?php if (!$rows): ?>
          <tr><td colspan="7" class="text-center text-muted">Sin registros</td></tr>
        <?php endif; ?>

        <?php foreach ($rows as $r): ?>
          <tr>
            <td><?= (int)$r['id'] ?></td>
            <td><?= htmlspecialchars($r['fecha']) ?></td>
            <td><?= htmlspecialchars($r['cliente']) ?></td>
            <td><?= htmlspecialchars($r['vendedor']) ?></td>
            <td><?= htmlspecialchars($r['concepto']) ?></td>
            <td>$<?= number_format((float)$r['monto'], 2) ?></td>
            <td>
              <a class="btn btn-sm btn-primary" href="edit.php?id=<?= (int)$r['id'] ?>">Editar</a>
              <form action="delete.php" method="post" class="d-inline" onsubmit="return confirm('¿Eliminar esta venta?');">
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
