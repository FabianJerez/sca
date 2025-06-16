<?php
session_start();
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST["usuario"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $password = $_POST["password"] ?? '';

    if (empty($usuario) || empty($email) || empty($password)) {
        header("Location: formulario_registro.php?error=1");
        exit();
    }

    try {
        // Verificar si el usuario o email ya existen
        $sql = "SELECT id FROM usuarios WHERE usuario = :usuario OR email = :email LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':usuario' => $usuario, ':email' => $email]);

        if ($stmt->fetch()) {
            // Ya existe
            header("Location: formulario_registro.php?error=1");
            exit();
        }

        // Hashear la contraseña
        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        $rol = "usuario";

        // Insertar nuevo usuario
        $sql = "INSERT INTO usuarios (usuario, password, hash_password, email, estado, fecha_inicio, rol)
                VALUES (:usuario, :password_raw, :hash_password, :email, 1, CURRENT_TIMESTAMP, :rol)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':usuario' => $usuario,
            ':password_raw' => $password, // opcional guardar sin hash
            ':hash_password' => $hash_password,
            ':email' => $email,
            ':rol' => $rol
        ]);

        // Registro exitoso
        header("Location: formulario_registro.php?success=1");
        exit();

    } catch (PDOException $e) {
        error_log("Error en registro: " . $e->getMessage());
        header("Location: formulario_registro.php?error=1");
        exit();
    }

} else {
    header("Location: formulario_registro.php");
    exit();
}

