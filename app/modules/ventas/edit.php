<?php
// app/modules/ventas/edit.php
require_once __DIR__ . '/../../auth/auth_guard.php';
require_login();
require_role(['ventas','admin']);

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header('Location: index.php'); exit; }

$stmt = $pdo->prepare("SELECT * FROM ventas WHERE id = :id");
$stmt->execute([':id' => $id]);
$venta = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$venta) { header('Location: index.php'); exit; }

$clientes   = ventas_fetch_clientes($pdo);
$vendedores = ventas_fetch_vendedores($pdo);

$errors = $_GET['errors'] ?? null;
?>
<div class="content">
  <h2 class="mb-3">Editar venta #<?= (int)$id ?></h2>

  <?php if ($errors): ?>
    <div class="alert alert-danger"><?= htmlspecialchars((string)$errors) ?></div>
  <?php endif; ?>

  <form method="post" action="update.php">
    <input type="hidden" name="id" value="<?= (int)$id ?>">
    <?php require __DIR__ . '/form.php'; ?>
  </form>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
