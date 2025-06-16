<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/headerfooter.css">
    <link rel="stylesheet" href="../css/registro.css">
</head>

<body>
    <?php include '../header.php' ?><br>
    <section class="register-section">
        <h3>Registro de usuario</h3>
        <form class="register-form" method="post" action="insertar_usuario.php">
            <label>Usuario:</label><br>
            <input type="text" name="usuario" required><br><br>

            <label>Email:</label><br>
            <input type="email" name="email" required><br><br>

            <label>Contraseña:</label><br>
            <input type="password" name="password" required><br><br>

            <button type="submit">Registrarse</button><br><br>
        </form>
    </section>
</body>

</html>