<?php
session_start();
require_once __DIR__ . '/config.php';

// Asegurarse que solo usuarios logueados accedan
if (!isset($_SESSION["usuario_id"])) {
    header("Location: " . BASE_URL . "login/login.php");
    exit();
}

// Rol del usuario (por ejemplo: cliente o administrador)
$rol = $_SESSION["usuario_rol"] ?? 'cliente';
$usuario_nombre = $_SESSION["usuario_nombre"] ?? 'Usuario';

// Sección seleccionada
$seccion = $_GET['seccion'] ?? 'iot';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Usuario - SCA SOFTWARE</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/panel.css">
</head>
<body>
    <div class="panel-container">
        <aside class="sidebar">
            <h2>Panel</h2>
            <p>Hola, <?= htmlspecialchars($usuario_nombre) ?></p>
            <ul>
                <li><a href="?seccion=iot" <?= $seccion === 'iot' ? 'class="activo"' : '' ?>>IoT</a></l
