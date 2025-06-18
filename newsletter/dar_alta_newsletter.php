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
    // Verificar si el usuario ya está activo
    $stmt = $conn->prepare("SELECT activo FROM newsletter WHERE id = ?");
    $stmt->execute([$id]);
    $estado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($estado && $estado['activo'] == 1) {
        echo "Este suscriptor ya está activo en el newsletter.";
    } else {
        $nuevo_token = generarToken();

        $stmt = $conn->prepare("UPDATE newsletter SET activo = 1, token = ?, fecha_suscripcion = NOW() WHERE id = ?");
        $stmt->execute([$nuevo_token, $id]);

        header("Location: ../panel.php?seccion=newsletter&sub=suscriptos");
        exit;
    }
} else {
    echo "ID del suscriptor no proporcionado.";
}