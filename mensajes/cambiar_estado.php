<?php
session_start();

// Verificamos que el usuario esté logueado
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login/login.html");
    exit;
}

// Verificamos que llegue el ID por GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "❌ ID inválido.";
    exit;
}

$id = intval($_GET['id']);

// Conectamos a la base de datos
require("conexion.php");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Actualizamos el estado del mensaje
$stmt = $conexion->prepare("UPDATE mensajes SET estado = 'Resuelto' WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: ver_mensajes.php"); // Volvemos al listado
    exit;
} else {
    echo "❌ Error al actualizar el estado.";
}

$stmt->close();
$conexion->close();
?>
