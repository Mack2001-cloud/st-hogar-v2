<?php
declare(strict_types=1);

$host = $host ?? getenv('DB_HOST') ?: 'localhost';
$db   = $db   ?? getenv('DB_NAME') ?: 'st_hogar';
$user = $user ?? getenv('DB_USER') ?: 'root';
$pass = $pass ?? getenv('DB_PASS') ?: '';
$charset = 'utf8mb4';

$dsn = "mysql:host={$host};dbname={$db};charset={$charset}";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    throw new RuntimeException('Database connection failed: ' . $e->getMessage(), (int)$e->getCode(), $e);
}

return $pdo;
