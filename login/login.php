<?php
session_start();
$redirect = $_POST["redirect"]?? '';//obtiene la redireccion 
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>LOGIN DE USUARIO</title>
    <link rel="stylesheet" href="../css/headerfooter.css">
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <?php include '../header.php' ?>
    <section class="login-section">
        <h3>Iniciar sesión</h3>
        <form class="login-form" method="post" action="consulta.php">
            <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect); ?>">

            <label>Usuario:</label><br>
            <input type="text" name="usuario" required><br><br>

            <label>Contraseña:</label><br>
            <input type="password" name="password" required><br><br>

            <button type="submit">Ingresar</button>
        </form>
        <p>¿No tenés una cuenta?</p>
        <a href="formulario_registro.php" class="btn-registrarse">Registrate</a>
    </section>

</body>

</html>
<?php if (isset($_GET['error']) && $_GET['error'] == '1'): ?>
    <p style="color: red;">⚠️ Usuario o contraseña incorrectos.</p>
<?php endif; ?>