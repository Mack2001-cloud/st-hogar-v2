<?php
// app/modules/ventas/create.php
require_once __DIR__ . '/../../auth/auth_guard.php';
require_login();
require_role(['ventas','admin']);

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';

$clientes   = ventas_fetch_clientes($pdo);
$vendedores = ventas_fetch_vendedores($pdo);

$venta = [
  'cliente_id' => '',
  'vendedor_id' => '',
  'concepto' => '',
  'monto' => '',
  'fecha' => date('Y-m-d'),
];

$errors = $_GET['errors'] ?? null;
?>
<div class="content">
  <h2 class="mb-3">Nueva venta</h2>

  <?php if ($errors): ?>
    <div class="alert alert-danger"><?= htmlspecialchars((string)$errors) ?></div>
  <?php endif; ?>

  <form method="post" action="store.php">
    <?php require __DIR__ . '/form.php'; ?>
  </form>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
