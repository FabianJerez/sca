<?php
$modo_embebido = true;

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/includes/utils.php';

if (!esAdministrativo()) {
    exit("Acceso denegado");
}

$id = $_GET['id'] ?? null;

if ($id) {
    // Consultar el estado actual del suscriptor
    $stmt = $conn->prepare("SELECT activo FROM newsletter WHERE id = ?");
    $stmt->execute([$id]);
    $estado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($estado && $estado['activo'] == 0) {
        echo "El suscriptor ya fue dado de baja del newsletter.";
    } else {
        $stmt = $conn->prepare("UPDATE newsletter SET activo = 0, token = NULL WHERE id = ?");
        $stmt->execute([$id]);

        header("Location: ../panel.php?seccion=newsletter&sub=suscriptos");
        exit;
    }
} else {
    echo "ID del suscriptor no proporcionado.";
}

