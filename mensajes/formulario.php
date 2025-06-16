<?php
session_start(); 
//si no esta logeado lo mando al login
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login/login.php?redirect=../contacto.php");
    exit;
}

//conexion a la BD
require("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $remitente = $_SESSION["usuario_nombre"]?? 'SinNombre';//por si no esta seteado
    $asunto = $_POST["asunto"] ?? '';
    $email = $_POST["email"] ?? '';
    $mensaje = $_POST["mensaje"] ?? '';
    $archivo_nombre = "";
    $estado = "Pendiente"; // Por defecto es "pendiente" una vez que se responde pasa a "resuelto"

    if (isset($_FILES['archivoAdjunto']) && $_FILES['archivoAdjunto']['error'] == 0) {
        $archivo_nombre = uniqid() . "_" . basename($_FILES['archivoAdjunto']['name']);
        $archivo_temp = $_FILES['archivoAdjunto']['tmp_name'];
    
        // Validación de formato y tamaño
        $permitidos = ['pdf'];
        $extension = strtolower(pathinfo($archivo_nombre, PATHINFO_EXTENSION));
    
        if (!in_array($extension, $permitidos)) {
            die("❌ Tipo de archivo no permitido.");
        }
    
        if ($_FILES['archivoAdjunto']['size'] > 2 * 1024 * 1024) {
            die("❌ El archivo supera los 2MB permitidos.");
        }
    
        // Subida del archivo
        $ruta_destino = "../uploads/" . basename($archivo_nombre);
        move_uploaded_file($archivo_temp, $ruta_destino);
    }
    
    //preparando consulta
    $stmt = $conexion->prepare("INSERT INTO mensajes (remitente,asunto, email, mensaje, archivo_nombre, estado) VALUES (?, ?, ?, ?, ?, ?)");//evitar la inyeccion de sql
    $stmt->bind_param("ssssss", $remitente, $asunto, $email, $mensaje, $archivo_nombre, $estado);//evitar la inyeccion de sql

    if ($stmt->execute()) {
        echo "<script>
                alert('✅ Mensaje enviado correctamente.');
                window.location.href = '../mensajes/mis_mensajes.php';
              </script>";
    } else {
        echo "<script>
                alert('❌ Error al guardar el mensaje.');
                window.location.href = '../contacto.php';
              </script>";
    }
    

    $stmt->close();
    $conexion->close();
}
?>