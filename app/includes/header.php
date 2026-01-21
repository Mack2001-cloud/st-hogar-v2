<?php
declare(strict_types=1);

require_once __DIR__ . '/../auth/auth_guard.php';
$user = current_user();
$error = flash_get('error');
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ST-HOGAR</title>
  <link rel="stylesheet" href="/public/assets/css/app.css">
</head>
<body>
<div class="layout">
<header class="topbar">
  <div class="brand">ST-HOGAR</div>
  <div class="topbar-right">
    <?php if ($user): ?>
      <span class="muted"><?= e($user['nombre'] ?? '') ?> (<?= e($user['rol'] ?? '') ?>)</span>
      <a class="btn small secondary" href="/app/auth/logout.php">Salir</a>
    <?php endif; ?>
  </div>
</header>

<?php if ($error): ?>
  <div class="container"><div class="alert alert-error"><?= e($error) ?></div></div>
<?php endif; ?>
