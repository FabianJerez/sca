<?php
$modo_embebido = $modo_embebido ?? false;

if (!$modo_embebido) {
    require_once __DIR__ . '/../includes/db.php';
    require_once __DIR__ . '/../includes/auth.php';
    require_once __DIR__ . '/includes/config.php';
    require_once __DIR__ . '/includes/utils.php';
} else {
    if (!function_exists('verificarYDarBajaAutomatica')) {
        require_once __DIR__ . '/includes/utils.php';
    }
    if (!defined('GMAIL_USER')) {
        require_once __DIR__ . '/includes/config.php';
    }
}

require_once __DIR__ . '/includes/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/includes/PHPMailer/Exception.php';
require_once __DIR__ . '/includes/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!esAdministrativo()) {
    exit("Acceso denegado");
}

// Aplicar limpieza automática si está implementada
verificarYDarBajaAutomatica($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $asunto = trim($_POST['asunto'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');

    if ($asunto && $mensaje) {
        $stmt = $conn->prepare("SELECT email, token FROM newsletter WHERE activo = 1");
        $stmt->execute();
        $destinatarios = $stmt->fetchAll();

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = GMAIL_USER;
            $mail->Password = GMAIL_APP_PASSWORD;
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ]
            ];

            $mail->setFrom(GMAIL_USER, 'SCA Software');
            $mail->isHTML(true);
            $mail->Subject = $asunto;

            foreach ($destinatarios as $d) {
                $mail->clearAllRecipients();
                $mail->addAddress($d['email']);

                $enlaceBaja = BASE_URL . "newsletter/newsletter_unsuscribe.php?token=" . urlencode($d['token']);
                $mail->Body = nl2br($mensaje) . "<hr><p style='font-size: small;'>Si no querés recibir más correos, podés <a href='$enlaceBaja'>desuscribirte aquí</a>.<br><br>Atte. Equipo SCA</p>";

                $mail->send();
            }

            echo "<p style='color: green;'>Newsletter enviado a <strong>" . count($destinatarios) . "</strong> suscriptores activos.</p>";
        } catch (Exception $e) {
            echo "<p style='color:red;'>Error al enviar: {$mail->ErrorInfo}</p>";
        }
    } else {
        echo "<p style='color:red;'>Asunto y mensaje son obligatorios.</p>";
    }
}
?>

<h2>Enviar Newsletter</h2>
<form method="POST">
    <label>Asunto:</label><br>
    <input type="text" name="asunto" required><br><br>

    <label>Mensaje:</label><br>
    <textarea name="mensaje" rows="10" style="width: 100%;" required></textarea><br><br>

    <button type="submit">Enviar Newsletter</button>
</form>
