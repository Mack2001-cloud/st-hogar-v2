<?php
// app/modules/servicios/form.php
require_once __DIR__ . '/helpers.php';

$estados  = servicios_estados();
$clientes = $clientes ?? [];
$tecnicos = $tecnicos ?? [];

$servicio = $servicio ?? [
  'id' => null,
  'cliente_id' => '',
  'tecnico_id' => '',
  'descripcion' => '',
  'fecha_servicio' => date('Y-m-d'),
  'estado' => 'pendiente',
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
            <?= ((string)$servicio['cliente_id'] === (string)$c['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($c['nombre']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Técnico</label>
      <select name="tecnico_id" class="form-select" required>
        <option value="">-- Selecciona --</option>
        <?php foreach ($tecnicos as $t): ?>
          <option value="<?= (int)$t['id'] ?>"
            <?= ((string)$servicio['tecnico_id'] === (string)$t['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($t['nombre']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Fecha del servicio</label>
      <input type="date" name="fecha_servicio" class="form-control"
             value="<?= htmlspecialchars((string)$servicio['fecha_servicio']) ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Estado</label>
      <select name="estado" class="form-select" required>
        <?php foreach ($estados as $e): ?>
          <option value="<?= htmlspecialchars($e) ?>"
            <?= ((string)$servicio['estado'] === (string)$e) ? 'selected' : '' ?>>
            <?= htmlspecialchars(str_replace('_',' ', $e)) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Descripción</label>
      <textarea name="descripcion" class="form-control" rows="4" required><?= htmlspecialchars((string)$servicio['descripcion']) ?></textarea>
    </div>

    <button class="btn btn-primary" type="submit">Guardar</button>
    <a class="btn btn-secondary" href="index.php">Cancelar</a>
  </div>
</div>
