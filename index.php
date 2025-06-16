<?php
session_start();
if (isset($_GET["logout"]) && $_GET["logout"] == 1) {
    echo "<p style='color: green;'>✅ Sesión cerrada correctamente.</p>";
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
    
    <?php include 'header.php'?>

    <section class="hero">
        <div class="hero-text">
            <h1>Somos una Pyme que desarrolla, fabrica e integra sistemas electronicos y Software de calidad</h1>
            <h3>Tenemos desarrollos enlatados y ademas de nuestra seccion de Servicio Tecnico para satisfacer su inversion con la garantia de PostVenta de todos los productos.</h3>
        </div>
    </section>

    <?php include 'footer.php'?>

</body>
</html>