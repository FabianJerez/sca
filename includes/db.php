<?php
require_once __DIR__ . '/../config.php';

try {
    $conn = new PDO(
        'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME,
        DB_USER,
        DB_PASS
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $conn->exec("SET NAMES utf8");
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

