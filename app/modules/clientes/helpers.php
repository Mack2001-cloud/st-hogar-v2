<?php
declare(strict_types=1);

function clientes_all(PDO $pdo): array {
    $stmt = $pdo->query("SELECT id_cliente, nombre, telefono, email, direccion FROM clientes ORDER BY id_cliente DESC");
    return $stmt->fetchAll();
}

function clientes_find(PDO $pdo, int $id): ?array {
    $stmt = $pdo->prepare("SELECT id_cliente, nombre, telefono, email, direccion FROM clientes WHERE id_cliente = :id");
    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function clientes_create(PDO $pdo, array $data): int {
    $stmt = $pdo->prepare("
        INSERT INTO clientes (nombre, telefono, email, direccion)
        VALUES (:nombre, :telefono, :email, :direccion)
    ");
    $stmt->execute([
        'nombre'    => $data['nombre'],
        'telefono'  => $data['telefono'],
        'email'     => $data['email'] ?: null,
        'direccion' => $data['direccion'] ?: null,
    ]);
    return (int)$pdo->lastInsertId();
}

function clientes_update(PDO $pdo, int $id, array $data): void {
    $stmt = $pdo->prepare("
        UPDATE clientes
        SET nombre = :nombre, telefono = :telefono, email = :email, direccion = :direccion
        WHERE id_cliente = :id
    ");
    $stmt->execute([
        'id'        => $id,
        'nombre'    => $data['nombre'],
        'telefono'  => $data['telefono'],
        'email'     => $data['email'] ?: null,
        'direccion' => $data['direccion'] ?: null,
    ]);
}

function clientes_delete(PDO $pdo, int $id): void {
    $stmt = $pdo->prepare("DELETE FROM clientes WHERE id_cliente = :id");
    $stmt->execute(['id' => $id]);
}
