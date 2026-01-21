<?php
declare(strict_types=1);

require_once __DIR__ . '/../../auth/auth_guard.php';
require_login();
require_role(['ventas','admin']);

$cliente = null;
$action = './store.php';

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>
<main class="content">
  <h2>Nuevo cliente</h2>
  <?php require __DIR__ . '/form.php'; ?>
</main>
