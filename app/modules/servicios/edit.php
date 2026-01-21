<?php
// app/modules/servicios/edit.php
require_once __DIR__ . '/../../auth/auth_guard.php';
require_login();
require_role(['tecnico','admin']);

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
  header('Location: index.php');
  exit;
}

$stmt = $pdo->prepare("SELECT * FROM servicios WHERE id = :id");
$stmt->execute([':id' => $id]);
$servicio = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$servicio) {
  header('Location: index.php');
  exit;
}

$clientes = servicios_fetch_clientes($pdo);
$tecnicos = servicios_fetch_tecnicos($pdo);

$errors = $_GET['errors'] ?? null;
?>
<div class="content">
  <h2 class="mb-3">Editar servicio #<?= (int)$id ?></h2>

  <?php if ($errors): ?>
    <div class="alert alert-danger">
      <?= htmlspecialchars((string)$errors) ?>
    </div>
  <?php endif; ?>

  <form method="post" action="update.php">
    <input type="hidden" name="id" value="<?= (int)$id ?>">
    <?php require __DIR__ . '/form.php'; ?>
  </form>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
