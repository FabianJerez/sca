<?php
session_start();
if (isset($_GET["logout"]) && $_GET["logout"] == 1) {
    echo "<p style='color: green;'>Sesión cerrada correctamente.</p>";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SCA Software ofrece soluciones de monitoreo IoT en Villa Madero, Buenos Aires.">
<meta name="keywords" content="Software, IoT, monitoreo, Buenos Aires">
    <title>SCA SOFTWARE</title>
   
    <link rel="stylesheet" href="css/headerfooter.css">
    <link rel="stylesheet" href="css/index.css">
    <script src="js/scripts.js"></script>
</head>
<body>
    <?php include 'header.php'?>
    <section class="hero">
        <div class="hero-text">
            <h1>Somos una Pyme que desarrolla, fabrica e integra sistemas electrónicos y software de calidad</h1>
            <h3>Ofrecemos desarrollos listos para usar, además de una sección de Servicio Técnico dedicada, garantizando postventa en todos nuestros productos.</h3>
        </div>
    </section>
    <?php include 'footer.php'?>
</body>
</html>