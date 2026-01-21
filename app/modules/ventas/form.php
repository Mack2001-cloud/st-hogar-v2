<?php
// app/modules/ventas/form.php
require_once __DIR__ . '/helpers.php';

$clientes   = $clientes ?? [];
$vendedores = $vendedores ?? [];

$venta = $venta ?? [
  'id' => null,
  'cliente_id' => '',
  'vendedor_id' => '',
  'concepto' => '',
  'monto' => '',
  'fecha' => date('Y-m-d'),
];
?>
<div class="card">
  <div class="card-body">
    <div class="mb-3">
      <label class="form-label">Cliente</label>
      <select name="cliente_id" class="form-select" required>
        <option value="">-- Selecciona --</option>
        <?php foreach ($clientes as $c): ?>
          <option value="<?= (int)$c['id'] ?>"
            <?= ((string)$venta['cliente_id'] === (string)$c['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($c['nombre']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Vendedor</label>
      <select name="vendedor_id" class="form-select" required>
        <option value="">-- Selecciona --</option>
        <?php foreach ($vendedores as $v): ?>
          <option value="<?= (int)$v['id'] ?>"
            <?= ((string)$venta['vendedor_id'] === (string)$v['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($v['nombre']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Fecha</label>
      <input type="date" name="fecha" class="form-control"
             value="<?= htmlspecialchars((string)$venta['fecha']) ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Concepto</label>
      <input type="text" name="concepto" class="form-control"
             value="<?= htmlspecialchars((string)$venta['concepto']) ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Monto</label>
      <input type="number" step="0.01" min="0" name="monto" class="form-control"
             value="<?= htmlspecialchars((string)$venta['monto']) ?>" required>
    </div>

    <button class="btn btn-primary" type="submit">Guardar</button>
    <a class="btn btn-secondary" href="index.php">Cancelar</a>
  </div>
</div>
