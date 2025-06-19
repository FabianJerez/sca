<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
requireLogin();

$usuario_nombre = $_SESSION["usuario_nombre"] ?? 'SinNombre';
$email = $_SESSION["email"] ?? '';
$mensaje_enviado = false;
$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $asunto = $_POST["asunto"] ?? '';
    $mensaje = $_POST["mensaje"] ?? '';
    $archivo_nombre = "";
    $estado = "Pendiente";

    if (isset($_FILES['archivoAdjunto']) && $_FILES['archivoAdjunto']['error'] === 0) {
        $archivo_nombre = uniqid() . "_" . basename($_FILES['archivoAdjunto']['name']);
        $archivo_temp = $_FILES['archivoAdjunto']['tmp_name'];

        $permitidos = ['pdf'];
        $extension = strtolower(pathinfo($archivo_nombre, PATHINFO_EXTENSION));

        if (!in_array($extension, $permitidos)) {
            $error = "❌ Tipo de archivo no permitido.";
        } elseif ($_FILES['archivoAdjunto']['size'] > 2 * 1024 * 1024) {
            $error = "❌ El archivo supera los 2MB permitidos.";
        } else {
            $ruta_destino = __DIR__ . '/../uploads/' . basename($archivo_nombre);
            move_uploaded_file($archivo_temp, $ruta_destino);
        }
    }

    if (!$error) {
        $stmt = $conn->prepare("INSERT INTO mensajes (remitente, asunto, email, mensaje, archivo_nombre, estado) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$usuario_nombre, $asunto, $email, $mensaje, $archivo_nombre, $estado]);
        $mensaje_enviado = true;
    }
}
?>

<h2>Enviar nuevo mensaje a SCA</h2>

<?php if ($mensaje_enviado): ?>
    <p style="color:green;">✅ Mensaje enviado correctamente.</p>
<?php elseif ($error): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <label for="asunto">Asunto:</label><br>
    <input type="text" name="asunto" required><br><br>

    <label for="mensaje">Mensaje:</label><br>
    <textarea name="mensaje" rows="6" required></textarea><br><br>

    <label for="archivoAdjunto">Archivo adjunto (PDF, máx 2MB):</label><br>
    <input type="file" name="archivoAdjunto" accept=".pdf"><br><br>

    <input type="submit" value="Enviar">
</form>
