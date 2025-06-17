<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login/login.php");
    exit();
}

$rol = $_SESSION["rol"] ?? 'usuario'; // valor por defecto

if ($rol === 'admin') {
    header("Location: paneles/panel_admin.php");
    exit();
} else {
    header("Location: paneles/panel_usuario.php");
    exit();
}
?>
