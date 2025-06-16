<?php

session_start();
// Verificar si el usuario está autenticado
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login/login.php");
    exit();
}


// Incluir los archivos necesarios de PHPMailer
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
require '../phpmailer/src/Exception.php';

// Usar los namespaces correctos
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include("conexion.php");
$usuario = $_SESSION["usu"];
echo "Hola buenos dias Usuario= ";
echo $usuario;
$sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
$resultado = $base->prepare($sql);
$resultado->execute([':usuario' => $usuario]);
                
            

foreach($resultado as $fila):
    
    $email =  $fila['email'] ;
       
endforeach;
    echo "Se envio un email a: ";
    echo $email;            


echo 'El email se armará';
try {
    // Crea una instancia de PHPMailer
    $mail = new PHPMailer(true);

    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'mail.scasoftware.com.ar'; // Servidor SMTP
    $mail->SMTPAuth = true;
    $mail->Username = 'info@scasoftware.com.ar'; // Tu correo
    $mail->Password = 'DanielInfo123456'; // Tu contraseña
    $mail->SMTPSecure = 'ssl'; // Cambiado a 'ssl' para el puerto 465
    $mail->Port = 465; // Puerto para SSL

    // Detalles del email
    $mail->setFrom('info@scasoftware.com.ar', 'SCA');
    $mail->addAddress($email, $usuario);
    //$mail->addAddress('scadaniel@hotmail.com', 'Daniel');

    // Asunto y cuerpo del mensaje
    $mail->Subject = 'Prueba1';
    $mail->Body = 'Este es el cuerpo del email de prueba';

    // Enviar el email
    if ($mail->send()) {
        echo 'El email se ha enviado correctamente.';
    } else {
        echo 'Error al enviar el email: ' . $mail->ErrorInfo;
    }
} catch (Exception $e) {
    echo 'Error al enviar el email: ' . $e->getMessage();
}
?>