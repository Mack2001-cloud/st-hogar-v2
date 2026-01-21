<?php
declare(strict_types=1);

require_once __DIR__ . '/../../auth/auth_guard.php';
require_login();
require_role(['ventas','admin']);

$pdo = require __DIR__ . '/../../config/db.php';

require_once __DIR__ . '/helpers.php';

$ok = flash_get('ok');
$rows = clientes_all($pdo);

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>
<main class="content">
  <div class="page-head">
    <h2>Clientes</h2>
    <a class="btn" href="./create.php">+ Nuevo cliente</a>
  </div>

  <?php if ($ok): ?>
    <div class="alert alert-ok"><?= e($ok) ?></div>
  <?php endif; ?>

  <div class="card">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th><th>Nombre</th><th>Teléfono</th><th>Email</th><th>Dirección</th><th>Acciones</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= (int)$r['id_cliente'] ?></td>
          <td><?= e((string)$r['nombre']) ?></td>
          <td><?= e((string)$r['telefono']) ?></td>
          <td><?= e((string)($r['email'] ?? '')) ?></td>
          <td><?= e((string)($r['direccion'] ?? '')) ?></td>
          <td class="actions-cell">
            <a class="btn small secondary" href="./edit.php?id=<?= (int)$r['id_cliente'] ?>">Editar</a>
            <form method="post" action="./delete.php" onsubmit="return confirm('¿Eliminar este cliente?');" style="display:inline">
              <input type="hidden" name="id_cliente" value="<?= (int)$r['id_cliente'] ?>">
              <button class="btn small danger" type="submit">Eliminar</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
