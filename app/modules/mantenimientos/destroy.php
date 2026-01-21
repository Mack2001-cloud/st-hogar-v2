<?php
require_once __DIR__ . '/../../includes/bootstrap.php';
require_login();
csrf_verify();

$id = (int)($_POST['id_mantenimiento'] ?? 0);

if ($id <= 0) {
  flash_set('danger', 'ID inválido.');
  redirect('index.php');
}

$stmt = $pdo->prepare("DELETE FROM mantenimientos WHERE id_mantenimiento=:id");
$stmt->execute(['id' => $id]);

flash_set('success', 'Mantenimiento eliminado.');
redirect('index.php');
