<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/db.php';

$usuario_id = $_SESSION["usuario_id"];
$usuario_nombre = $_SESSION["usuario_nombre"] ?? '';

// Insertar mensaje si viene por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['contenido'])) {
    $contenido = trim($_POST['contenido']);
    $stmt = $conn->prepare("INSERT INTO mensajes (usuario_id, contenido, fecha) VALUES (:usuario_id, :contenido, NOW())");
    $stmt->execute([
        ':usuario_id' => $usuario_id,
        ':contenido' => $contenido
    ]);
    echo "<p style='color:green;'>Mensaje enviado con éxito.</p>";
}

// Obtener mensajes previos del usuario (opcional)
$stmt = $conn->prepare("SELECT * FROM mensajes WHERE usuario_id = :usuario_id ORDER BY fecha DESC");
$stmt->execute([':usuario_id' => $usuario_id]);
$mensajes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Mensajes</h2>

<form method="POST">
    <label for="contenido">Escribe tu mensaje:</label><br>
    <textarea name="contenido" id="contenido" rows="4" cols="50" required></textarea><br>
    <button type="submit">Enviar</button>
</form>

<h3>Mis mensajes enviados</h3>
<?php if (count($mensajes) > 0): ?>
    <ul>
        <?php foreach ($mensajes as $mensaje): ?>
            <li>
                <strong><?= htmlspecialchars($mensaje['fecha']) ?>:</strong>
                <?= htmlspecialchars($mensaje['contenido']) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Aún no has enviado ningún mensaje.</p>
<?php endif; ?>
