<?php
session_start();
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/db.php';

try {
    $usuario = trim($_POST["usuario"] ?? '');
    $password = $_POST["password"] ?? '';
    $redirect = $_POST["redirect"] ?? '';

    $sql = "SELECT * FROM usuarios WHERE usuario = :usuario AND estado = 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':usuario' => $usuario]);
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($fila && password_verify($password, $fila["hash_password"])) {
        $_SESSION["usu"] = $usuario;
        $_SESSION["usuario_id"] = $fila["id"];
        $_SESSION["usuario_nombre"] = $fila["usuario"];
        $_SESSION["rol"] = $fila["rol"];
        $_SESSION["email"] = $fila["email"];

        $destino = BASE_URL . "panel.php";

        // Validación básica del redirect
        if (!empty($redirect) && str_starts_with($redirect, "panel.php")) {
            $destino = BASE_URL . $redirect;
        }

        header("Location: $destino");
        exit();
    } else {
        header("Location: login.php?error=1");
        exit();
    }
} catch (PDOException $e) {
    // En producción, se puede loggear el error en un archivo
    error_log("Error login: " . $e->getMessage());
    header("Location: login.php?error=1");
    exit();
}
