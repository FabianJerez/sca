<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config.php'; // Asegurate que este archivo existe y define BASE_URL
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/headerfooter.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/registro.css">
</head>

<body>
    <?php include '../header.php'; ?>

    <section class="register-section">
        <h3>Registro de usuario</h3>

        <?php if (isset($_GET["error"]) && $_GET["error"] === "1"): ?>
            <p style="color: red;">El usuario o email ya están registrados.</p>
        <?php elseif (isset($_GET["success"])): ?>
            <p style="color: green;">Registro exitoso. Ya podés iniciar sesión.</p>
        <?php endif; ?>

        <form class="register-form" method="post" action="insertar_usuario.php">
            <label for="usuario">Usuario:</label><br>
            <input type="text" name="usuario" id="usuario" required><br><br>

            <label for="email">Email:</label><br>
            <input type="email" name="email" id="email" required><br><br>

            <label for="password">Contraseña:</label><br>
            <input type="password" name="password" id="password" required><br><br>

            <button type="submit">Registrarse</button>
        </form>
    </section>

    <?php include '../footer.php'; ?>
</body>

</html>
