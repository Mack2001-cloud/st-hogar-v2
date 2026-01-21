<?php
declare(strict_types=1);

require_once __DIR__ . '/../../auth/auth_guard.php';
require_login();
require_role(['ventas','admin']);

$pdo = require __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/helpers.php';

$id = (int)($_GET['id'] ?? 0);
$cliente = $id ? clientes_find($pdo, $id) : null;

if (!$cliente) {
    http_response_code(404);
    echo "Cliente no encontrado";
    exit;
}

$action = './update.php';

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>
<main class="content">
  <h2>Editar cliente</h2>
  <?php require __DIR__ . '/form.php'; ?>
</main>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
