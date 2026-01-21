<?php
// app/modules/servicios/create.php
require_once __DIR__ . '/../../auth/auth_guard.php';
require_login();
require_role(['tecnico','admin']);

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';

$clientes = servicios_fetch_clientes($pdo);
$tecnicos = servicios_fetch_tecnicos($pdo);

$servicio = [
  'cliente_id' => '',
  'tecnico_id' => '',
  'descripcion' => '',
  'fecha_servicio' => date('Y-m-d'),
  'estado' => 'pendiente',
];

$errors = $_GET['errors'] ?? null;
?>
<div class="content">
  <h2 class="mb-3">Nuevo servicio</h2>

  <?php if ($errors): ?>
    <div class="alert alert-danger">
      <?= htmlspecialchars((string)$errors) ?>
    </div>
  <?php endif; ?>

  <form method="post" action="store.php">
    <?php require __DIR__ . '/form.php'; ?>
  </form>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
