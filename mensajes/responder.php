<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login/login.php");
    exit;
}
require_once __DIR__ . '/../includes/db.php';
$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<p>Error: No se recibió el ID del mensaje.</p>";
    return;
}
$respuesta = $_POST['respuesta'] ?? null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id && $respuesta) {
    // Actualizar mensaje con la respuesta y marcar como resuelto
    $stmt = $conn->prepare("UPDATE mensajes SET respuesta = ?, estado = 'Resuelto' WHERE id = ?");
    $stmt->execute([$respuesta, $id]);
    header("Location: " . BASE_URL . "panel.php?seccion=mensajes&sub=ver");
    exit;
}
// Obtener mensaje original
$stmt = $conn->prepare("SELECT * FROM mensajes WHERE id = ?");
$stmt->execute([$id]);
$mensaje = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$mensaje) {
    echo "Mensaje no encontrado.";
    exit;
}
?>
<h2>Responder mensaje</h2>
<br>
<p><strong>Remitente:</strong> <?= htmlspecialchars($mensaje['remitente']) ?></p>
<br>
<p><strong>Asunto:</strong> <?= htmlspecialchars($mensaje['asunto']) ?></p>
<br>
<p><strong>Mensaje:</strong><br><?= nl2br(htmlspecialchars($mensaje['mensaje'])) ?></p>
<br>
<form method="post">
    <label for="respuesta">Tu respuesta:</label><br>
    <textarea name="respuesta" id="respuesta" rows="5" cols="50" required><?= htmlspecialchars($mensaje['respuesta'] ?? '') ?></textarea><br><br>
    <button type="submit">Enviar respuesta</button>
</form>
