<?php
// Espera: $cliente (array|null) y $action (string)
$id = $cliente['id_cliente'] ?? null;
$nombre = $cliente['nombre'] ?? '';
$telefono = $cliente['telefono'] ?? '';
$email = $cliente['email'] ?? '';
$direccion = $cliente['direccion'] ?? '';
?>
<form method="post" action="<?= e($action) ?>" class="card">
  <?php if ($id): ?>
    <input type="hidden" name="id_cliente" value="<?= (int)$id ?>">
  <?php endif; ?>

  <div class="grid">
    <div>
      <label>Nombre</label>
      <input type="text" name="nombre" required value="<?= e((string)$nombre) ?>">
    </div>

    <div>
      <label>Teléfono</label>
      <input type="text" name="telefono" required value="<?= e((string)$telefono) ?>">
    </div>

    <div>
      <label>Email</label>
      <input type="email" name="email" value="<?= e((string)$email) ?>">
    </div>

    <div class="col-span-2">
      <label>Dirección</label>
      <input type="text" name="direccion" value="<?= e((string)$direccion) ?>">
    </div>
  </div>

  <div class="actions">
    <button type="submit">Guardar</button>
    <a class="btn secondary" href="./index.php">Cancelar</a>
  </div>
</form>
