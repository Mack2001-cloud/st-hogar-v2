<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/auth/auth_guard.php';
require_login();

$user = current_user();

require_once __DIR__ . '/../app/includes/header.php';
require_once __DIR__ . '/../app/includes/sidebar.php';
?>
<main class="content">
  <h2>Dashboard</h2>
  <p class="muted">Bienvenido, <?= e($user['nombre'] ?? '') ?>.</p>

  <div class="grid-cards">
    <a class="card link" href="/app/modules/clientes/index.php">Clientes</a>
    <a class="card link" href="/app/modules/ventas/index.php">Ventas</a>
    <a class="card link" href="/app/modules/servicios/index.php">Servicios</a>
    <a class="card link" href="/app/modules/mantenimientos/index.php">Mantenimientos</a>
    <a class="card link" href="/app/modules/equipos/index.php">Equipos</a>
  </div>

  <p class="muted small">Nota: si aún no creas los módulos de Servicios/Ventas/etc., esos enlaces te marcarán error hasta que existan.</p>
</main>
<?php require_once __DIR__ . '/../app/includes/footer.php'; ?>