<?php
declare(strict_types=1);

require_once __DIR__ . '/auth_guard.php';

start_app_session();
if (is_logged_in()) {
    header('Location: ' . AUTH_HOME_PATH);
    exit;
}

$error = flash_get('error');
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Iniciar sesión | ST-HOGAR</title>
  <link rel="stylesheet" href="/public/assets/css/app.css">
</head>
<body class="auth-bg">
  <div class="auth-card">
    <h1>ST-HOGAR</h1>
    <p class="muted">Acceso al sistema</p>

    <?php if ($error): ?>
      <div class="alert alert-error"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="post" action="/app/auth/validar_login.php" autocomplete="off">
      <label for="identifier">Usuario o correo</label>
      <input type="text" id="identifier" name="identifier" required>

      <label for="password">Contraseña</label>
      <input type="password" id="password" name="password" required>

      <button type="submit">Entrar</button>
    </form>

    <p class="muted small">© <?= date('Y') ?> ST-HOGAR</p>
  </div>
</body>
</html>
