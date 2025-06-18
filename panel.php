<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/db.php';

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login/login.php");
    exit();
}

$rol = $_SESSION["rol"];
$vista = $_GET['vista'] ?? 'home';
$seccion = $_GET['seccion'] ?? '';
$subseccion = $_GET['sub'] ?? '';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Principal</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/headerfooter.css">

    <link rel="stylesheet" href="<?= BASE_URL ?>css/panel2.css">

</head>
<body>

<?php include 'header.php'; ?>

<div class="panel-container">
    <!-- Barra lateral -->
    <aside class="sidebar">
        <h3>Panel</h3>
        <br>
        <ul>
            <li><a href="panel.php?seccion=iot">IOT</a></li>
            <br>
            <li><a href="panel.php?seccion=mensajes">Mensajes</a></li>
            <br>
            <li><a href="panel.php?seccion=newsletter">Newsletter</a></li>
        </ul>
    </aside>
    <div class="panel-body">
        <!-- Barra superior dinámica -->
        <nav class="subnav">
            <?php if ($seccion === 'iot'): ?>
                <a href="panel.php?seccion=iot&sub=ver">Ver Chips</a>
                <a href="panel.php?seccion=iot&sub=agregar">Agregar Chip</a>
            <?php elseif ($seccion === 'mensajes'): ?>
                <a href="panel.php?seccion=mensajes&sub=ver">Ver Mensajes</a>
                <!-- <a href="panel.php?seccion=mensajes&sub=responder">Responder</a> -->
            <?php elseif ($seccion === 'newsletter'): ?>
                <a href="panel.php?seccion=newsletter&sub=suscriptos">Ver Suscriptos</a>
                <a href="panel.php?seccion=newsletter&sub=envios">Envios</a>
            <?php endif; ?>
        </nav>
        <!-- Contenido principal -->
        <main class="panel-content">
            <?php
            if ($seccion === 'iot') {
                if ($subseccion === 'ver') {
                    include 'paneles/iot/ver_chips.php';
                } elseif ($subseccion === 'agregar') {
                    include 'paneles/iot/agregar_chip.php';
                } else {
                    echo "<p>Seleccioná una opción de IOT.</p>";
                }
            }
            elseif ($seccion === 'mensajes') {
                if (isset($_GET['id'])) {
                    include 'mensajes/responder.php'; // ✅ responder.php sin HTML
                } else {
                    include 'mensajes/ver_mensajes.php';
                }
            }

            elseif ($seccion === 'newsletter') {
                if ($subseccion === 'suscriptos') {
                    include 'paneles/newsletter/suscriptos.php';
                } elseif ($subseccion === 'envios') {
                    include 'paneles/newsletter/envios.php';
                } else {
                    echo "<p>Seleccioná una opción de Newsletter.</p>";
                }
            }
            else {
                echo "<p>Elegí una sección desde la barra lateral.</p>";
            }
            ?>
        </main>
    </div>

</div>

</body>
</html>

