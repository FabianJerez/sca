<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Asegura que no haya múltiples session_start()
}

function getUserRole() {
    return $_SESSION['rol'] ?? null;
}

function getUserId() {
    return $_SESSION['usuario_id'] ?? null; // Asegurate que el índice sea 'usuario_id'
}

function isLoggedIn() {
    return isset($_SESSION['usuario_id']);
}

function esCliente() {
    return getUserRole() === 'usuario';
}

function esAdministrativo() {
    return getUserRole() === 'admin';
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: " . BASE_URL . "login/login.php");
        exit;
    }
}

