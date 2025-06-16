<?php
session_start();
if (!isset($_SESSION["usuario_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: ../login/login.php");
    exit;
}

require("conexion.php");

$id = $_GET['id'] ?? null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $respuesta = $_POST["respuesta"] ?? '';

    $stmt = $conexion->prepare("UPDATE mensajes SET respuesta = ?, estado = 'Resuelto' WHERE id = ?");
    $stmt->bind_param("si", $respuesta, $id);

    if ($stmt->execute()) {
        header("Location: ver_mensajes.php");
        exit;
    } else {
        echo "❌ Error al guardar la respuesta.";
    }
    $stmt->close();
}

// Traer mensaje para mostrarlo
$stmt = $conexion->prepare("SELECT * FROM mensajes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$mensaje = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Responder Mensaje</title>
</head>
<body>
    <h2>Responder a: <?php echo htmlspecialchars($mensaje['remitente']); ?></h2>
    <p><strong>Asunto:</strong> <?php echo htmlspecialchars($mensaje['asunto']); ?></p>
    <p><strong>Mensaje:</strong> <?php echo nl2br(htmlspecialchars($mensaje['mensaje'])); ?></p>

    <form method="post">
        <label for="respuesta">Respuesta:</label><br>
        <textarea name="respuesta" rows="5" cols="60" required></textarea><br><br>
        <button type="submit">Enviar Respuesta</button>
    </form>

    <p><a href="ver_mensajes.php">⬅️ Volver a la lista</a></p>
</body>
</html>
