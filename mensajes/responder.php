<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login/login.php");
    exit;
}

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../newsletter/includes/config.php'; // Contiene GMAIL_USER y GMAIL_APP_PASSWORD

require_once __DIR__ . '/../newsletter/includes/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../newsletter/includes/PHPMailer/SMTP.php';
require_once __DIR__ . '/../newsletter/includes/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Validar ID
$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    echo "<p style='color:red;'>❌ ID del mensaje no válido.</p>";
    exit;
}

// Obtener el mensaje original
$stmt = $conn->prepare("SELECT * FROM mensajes WHERE id = ?");
$stmt->execute([$id]);
$mensaje = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$mensaje) {
    echo "<p style='color:red;'>❌ Mensaje no encontrado.</p>";
    exit;
}

// Si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $respuesta = trim($_POST['respuesta'] ?? '');

    if ($respuesta !== '') {
        $stmt = $conn->prepare("UPDATE mensajes SET respuesta = ?, estado = 'Resuelto' WHERE id = ?");
        $stmt->execute([$respuesta, $id]);

        // Enviar correo al remitente
        $para = $mensaje['email'];
        $asunto = "Respuesta a tu mensaje: " . $mensaje['asunto'];

        $cuerpo = "<p>Hola <strong>" . htmlspecialchars($mensaje['remitente']) . "</strong>,</p>";
        $cuerpo .= "<p>Recibimos tu mensaje:</p>";
        $cuerpo .= "<blockquote>" . nl2br(htmlspecialchars($mensaje['mensaje'])) . "</blockquote>";
        $cuerpo .= "<p>Nuestra respuesta:</p>";
        $cuerpo .= "<blockquote>" . nl2br(htmlspecialchars($respuesta)) . "</blockquote>";
        $cuerpo .= "<br><p>Gracias por contactarte con nosotros.<br>Equipo SCA.</p>";

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = GMAIL_USER;
            $mail->Password = GMAIL_APP_PASSWORD;
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom(GMAIL_USER, 'SCA');
            $mail->addAddress($para);
            $mail->isHTML(true);
            $mail->Subject = $asunto;
            $mail->Body    = $cuerpo;

            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ]
            ];


            $mail->send();
        } catch (Exception $e) {
            echo "No se pudo enviar el correo de respuesta. Error: {$mail->ErrorInfo}";
            exit;
        }

// Redirigir después de enviar
header("Location: " . BASE_URL . "panel.php?seccion=mensajes&sub=ver");
exit;

    } else {
        echo "<p style='color:red;'>❌ La respuesta no puede estar vacía.</p>";
    }
}
?>

<h2>Responder mensaje</h2>
<p><strong>Remitente:</strong> <?= htmlspecialchars($mensaje['remitente']) ?></p>
<p><strong>Asunto:</strong> <?= htmlspecialchars($mensaje['asunto']) ?></p>
<p><strong>Mensaje:</strong><br><?= nl2br(htmlspecialchars($mensaje['mensaje'])) ?></p>

<form method="post">
    <label for="respuesta">Tu respuesta:</label><br>
    <textarea name="respuesta" id="respuesta" rows="5" cols="50" required><?= htmlspecialchars($mensaje['respuesta'] ?? '') ?></textarea><br><br>
    <button type="submit">Enviar respuesta</button>
</form>


