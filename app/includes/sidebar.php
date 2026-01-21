<?php
declare(strict_types=1);

require_once __DIR__ . '/../auth/auth_guard.php';
$user = current_user();
$rol = $user['rol'] ?? '';
?>
<aside class="sidebar">
  <nav>
    <a href="/public/index.php">Dashboard</a>

    <?php if (in_array($rol, ['ventas','admin'], true)): ?>
      <a href="/app/modules/clientes/index.php">Clientes</a>
      <a href="/app/modules/ventas/index.php">Ventas</a>
    <?php endif; ?>

    <?php if (in_array($rol, ['tecnico','admin'], true)): ?>
      <a href="/app/modules/servicios/index.php">Servicios</a>
      <a href="/app/modules/mantenimientos/index.php">Mantenimientos</a>
      <a href="/app/modules/equipos/index.php">Equipos</a>
    <?php endif; ?>
  </nav>
</aside>
