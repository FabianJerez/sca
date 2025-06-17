<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

        // Redirección según rol
        if (strtolower($fila["rol"]) === "admin") {
            $destino = BASE_URL . "paneles/panel_admin.php";
        } else {
            $destino = BASE_URL . "paneles/panel_usuario.php";
        }
        // Si vino un redirect personalizado válido, se respeta
        if (!empty($redirect) && !preg_match('/^https?:\/\//', $redirect)) {
            $destino = BASE_URL . ltrim($redirect, '/');
        }

        header("Location: $destino");
        exit();
    } else {
        header("Location: " . BASE_URL . "login/login.php?error=1");
        exit();
    }
} catch (PDOException $e) {
    error_log("Error login: " . $e->getMessage());
    header("Location: " . BASE_URL . "login/login.php?error=1");
    exit();
}
?>
