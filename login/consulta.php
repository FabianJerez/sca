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

        header("Location: ../panel.php");
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
