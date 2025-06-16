<?php
session_start();
require_once __DIR__ . '/config.php';

if (!isset($_SESSION["usuario_id"])) {
    // Redirigir al login
    header("Location: " . BASE_URL . "login/login.php?redirect=panel.php?seccion=mensajes");
    exit();
} else {
    // Si ya está logueado, ir directo al panel
    header("Location: " . BASE_URL . "panel.php?seccion=mensajes");
    exit();
}
?>
