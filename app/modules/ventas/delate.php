<?php
// app/modules/ventas/delete.php
require_once __DIR__ . '/../../auth/auth_guard.php';
require_login();
require_role(['ventas','admin']);

require_once __DIR__ . '/../../config/db.php';

$id = (int)($_POST['id'] ?? 0);
if ($id > 0) {
  $stmt = $pdo->prepare("DELETE FROM ventas WHERE id = :id");
  $stmt->execute([':id' => $id]);
}

header('Location: index.php?ok=1');
exit;
