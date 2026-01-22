<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/auth/auth_guard.php';
require_login();

$user = current_user();

require_once __DIR__ . '/../app/includes/header.php';
require_once __DIR__ . '/../app/includes/sidebar.php';
?>
<main class="content">
  <section class="hero">
    <div>
      <h2 class="hero-title">Dashboard</h2>
      <p class="muted">Bienvenido, <?= e($user['nombre'] ?? '') ?>. Ten a mano lo esencial y avanza rápido con tareas clave.</p>
    </div>
    <div class="hero-actions">
      <a class="btn" href="/app/modules/clientes/index.php">Nuevo cliente</a>
      <a class="btn secondary" href="/app/modules/ventas/index.php">Registrar venta</a>
    </div>
  </section>

  <section class="grid stats-grid">
    <div class="card stat-card">
      <p class="stat-label muted">Clientes activos</p>
      <p class="stat-value">--</p>
      <p class="muted small">Conecta contactos y segmentos.</p>
    </div>
    <div class="card stat-card">
      <p class="stat-label muted">Ventas del mes</p>
      <p class="stat-value">--</p>
      <p class="muted small">Mantén el pulso comercial.</p>
    </div>
  </section>

  <section>
    <div class="section-head">
      <h3>Módulos</h3>
      <p class="muted small">Accesos rápidos para gestionar lo diario.</p>
    </div>
    <div class="grid-cards">
      <a class="card link" href="/app/modules/clientes/index.php">
        <div>
          <h4 class="card-title">Clientes</h4>
          <p class="card-desc muted">Alta, edición y seguimiento de clientes.</p>
        </div>
        <span class="badge">Gestión</span>
      </a>
      <a class="card link" href="/app/modules/ventas/index.php">
        <div>
          <h4 class="card-title">Ventas</h4>
          <p class="card-desc muted">Registra ventas, montos y estados.</p>
        </div>
        <span class="badge badge-accent">Comercial</span>
      </a>
      <a class="card link link-disabled" href="/app/modules/servicios/index.php" aria-disabled="true">
        <div>
          <h4 class="card-title">Servicios</h4>
          <p class="card-desc muted">Define paquetes y servicios frecuentes.</p>
        </div>
        <span class="badge badge-muted">Próximamente</span>
      </a>
      <a class="card link link-disabled" href="/app/modules/mantenimientos/index.php" aria-disabled="true">
        <div>
          <h4 class="card-title">Mantenimientos</h4>
          <p class="card-desc muted">Planifica tareas periódicas y alertas.</p>
        </div>
        <span class="badge badge-muted">Próximamente</span>
      </a>
      <a class="card link link-disabled" href="/app/modules/equipos/index.php" aria-disabled="true">
        <div>
          <h4 class="card-title">Equipos</h4>
          <p class="card-desc muted">Inventario y estado de equipos.</p>
        </div>
        <span class="badge badge-muted">Próximamente</span>
      </a>
    </div>
  </section>
</main>
<?php require_once __DIR__ . '/../app/includes/footer.php'; ?>
