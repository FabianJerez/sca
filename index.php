<?php
session_start();
$mensaje_logout = '';
if (isset($_GET["logout"]) && $_GET["logout"] == 1) {
    $mensaje_logout = "Sesión cerrada correctamente.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SCA Automatizaciones ofrece soluciones de monitoreo IoT y automatización industrial en Villa Madero, Buenos Aires.">
    <meta name="keywords" content="automatizaciones, IoT, monitoreo, Buenos Aires">
    <title>SCA SOFTWARE</title>

    <link rel="stylesheet" href="css/headerfooter.css">
    <link rel="stylesheet" href="css/index.css">
    <script src="js/scripts.js"></script>
</head>
<body>

    <?php include 'header.php'; ?>

    <?php if ($mensaje_logout): ?>
        <div style="background-color: #e6ffe6; padding: 10px; border: 1px solid green; margin: 15px;">
            <?= htmlspecialchars($mensaje_logout) ?>
        </div>
    <?php endif; ?>

    <section class="hero">
        <div class="hero-text">
            <h1>Somos una Pyme que desarrolla, fabrica e integra sistemas electrónicos y software de calidad</h1>
            <h3>Tenemos desarrollos enlatados y además contamos con una sección de servicio técnico para acompañar su inversión con garantía de postventa.</h3>
        </div>
    </section>

    <?php include 'footer.php'; ?>

</body>
</html>
