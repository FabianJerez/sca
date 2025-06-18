<?php
require_once __DIR__ . '/../includes/db.php';

$token = $_GET['token'] ?? '';

if (empty($token)) {
    exit("Token inválido.");
}

$stmt = $conn->prepare("UPDATE newsletter SET activo = 0 WHERE token = ?");
$stmt->execute([$token]);

if ($stmt->rowCount() > 0) {
    echo "<h2>Te desuscribiste del newsletter correctamente.</h2>";
} else {
    echo "<h2>El enlace es inválido o ya te habías desuscripto.</h2>";
}
