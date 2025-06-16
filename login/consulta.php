<?php
session_start(); // Iniciamos la sesión solo una vez

include("conexion.php");

try {
    // Obtenemos los datos del formulario
    $usuario = $_POST["usuario"] ?? '';
    $password = $_POST["password"] ?? '';

    // Buscamos el usuario en la base
    $sql = "SELECT * FROM usuarios WHERE usuario = :usuario AND estado = 1";
    $resultado = $base->prepare($sql);
    $resultado->execute([':usuario' => $usuario]);

    // Verificamos si se encontró un usuario
    $fila = $resultado->fetch(PDO::FETCH_ASSOC);

    if ($fila) { // Si se encontró un usuario
        // Verificamos la contraseña
        if (password_verify($password, $fila["hash_password"])) {
            // Login correcto, creamos la sesión
            $_SESSION["usu"] = $usuario;
            $_SESSION["usuario_id"] = $fila["id"];
            $_SESSION["usuario_nombre"] = $fila["usuario"];
            $_SESSION["rol"] = $fila["rol"];
            $_SESSION["email"] = $fila["email"];

            // Determinar el destino según el rol
            $destino = strtolower(trim($fila["rol"])) === "admin" ? "../paneles/panel_admin.php" : "../paneles/panel_usuario.php";

            // Verificamos si hay un redirect personalizado
            $redirect = $_POST["redirect"] ?? '';
            if (!empty($redirect) && str_starts_with($redirect, "../")) {
                $destino = $redirect; // Usar redirect si es válido
            }

            // Redirigimos
            header("Location: $destino");
            exit(); // Aseguramos que el script termine
        } else {
            // Contraseña incorrecta
            header("Location: login.php?error=1");
            exit();
        }
    } else {
        // Usuario no encontrado o inactivo
        header("Location: login.php?error=1");
        exit();
    }
} catch (PDOException $e) {
    // Mostrar error solo para depuración (en producción, redirigir o registrar el error)
    echo "Error en la consulta: " . $e->getMessage() . "<br>";
    echo "Línea de error: " . $e->getLine();
    exit();
}
?>