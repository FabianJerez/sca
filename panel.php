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

// if($rol === 'usuario'){
//     include 'paneles/panel_usuario.php';
// }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Principal</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/headerfooter.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/panel_general.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="panel-container">
    <!-- Barra lateral -->
    <aside class="sidebar">
        <h3>Panel</h3>
        <form method="get" action="panel.php" style="display: flex; flex-direction: column; gap: 10px; margin-top: 15px;">
            <input type="hidden" name="vista" value="home">

            <button type="submit" name="seccion" value="iot">IOT</button>
            <button type="submit" name="seccion" value="mensajes">Mensajes</button>
            <button type="submit" name="seccion" value="newsletter">Newsletter</button>
        </form>
    </aside>

    <div class="panel-body">
        <!-- Barra superior dinámica -->
        <nav class="subnav">
            <?php if ($seccion === 'iot'): ?>
                <?php if ($rol === 'admin'): ?>
                    <a href="panel.php?seccion=iot&sub=valores">Valores Actuales</a>
                    <a href="panel.php?seccion=iot&sub=ultimos">Ultimos Registros Recibidos</a>
                    <a href="panel.php?seccion=iot&sub=chips">CHIPIDs Registrados</a>
                <?php elseif ($rol === 'usuario'): ?>
                    <a href="panel.php?seccion=iot&sub=chips">CHIPIDs Registrados</a>
                <?php endif; ?>

            <?php elseif ($seccion === 'mensajes'): ?>
                <?php if ($rol === 'admin'): ?>
                    <a href="panel.php?seccion=mensajes&sub=ver">Ver Mensajes</a>
                <?php elseif ($rol === 'usuario'): ?>
                    <a href="panel.php?seccion=mensajes&sub=mis">Mis Mensajes</a>
                    <a href="panel.php?seccion=mensajes&sub=enviar">Enviar mensaje</a>
                <?php endif; ?>

            <?php elseif ($seccion === 'newsletter'): ?>
                <?php if ($rol === 'admin'): ?>
                    <a href="panel.php?seccion=newsletter&sub=suscriptos">Ver Clientes</a>
                    <a href="panel.php?seccion=newsletter&sub=envios">Enviar Newsletter</a>
                    <a href="panel.php?seccion=newsletter&sub=baja">Bajas Automáticas</a>
                <?php elseif ($rol === 'usuario'): ?>
                    <a href="panel.php?seccion=newsletter&sub=suscripcion">Suscribirse al Newsletter</a>
                <?php endif; ?>
            <?php endif; ?>

        </nav>
        <!-- Contenido principal -->
        <main class="panel-content">
            <?php
            if ($seccion === 'iot') {
                
                    if ($subseccion === 'valores') {
                        include __DIR__ . '/iot/valores_actuales.php';
                    } elseif ($subseccion === 'ultimos') {
                        include __DIR__ . '/iot/ultimos_registros.php';
                    } elseif ($subseccion === 'chips') {
                        include __DIR__ . '/iot/chipids_registrados.php';
                    } else {
                        echo "<p>Seleccioná una opción de IOT.</p>";
                    }
            }
            elseif ($seccion === 'mensajes') {
                if ($rol === 'admin') {
                    if ($subseccion === 'ver') {
                        include 'mensajes/ver_mensajes.php';
                    } elseif ($subseccion === 'responder' && isset($_GET['id'])) {
                        include 'mensajes/responder.php';
                    } else {
                        echo "<p>Seleccioná una opción de Mensajes desde la barra superior.</p>";
                    }
                } elseif ($rol === 'usuario') {
                    if ($subseccion === 'mis') {
                        include 'mensajes/mis_mensajes.php';
                    } elseif ($subseccion === 'enviar') {
                        include 'mensajes/enviar_mensaje.php';
                    } else {
                        echo "<p>Seleccioná una opción de Mensajes desde la barra superior.</p>";
                    }
                } else {
                    echo "<p>Acceso no autorizado.</p>";
                }
            }
            elseif ($seccion === 'newsletter') {
                if ($rol === 'admin') {
                    if ($subseccion === 'suscriptos') {
                        include 'newsletter/usuarios.php';
                    } elseif ($subseccion === 'envios') {
                        include 'newsletter/enviar_newsletter.php';
                    } elseif ($subseccion === 'baja') {
                        include 'newsletter/cron_baja.php';
                    } else {
                        echo "<p>Seleccioná una opción de Newsletter desde la barra superior.</p>";
                    }
                } elseif ($rol === 'usuario') {
                    if ($subseccion === 'suscripcion') {
                        include 'newsletter/suscripcion.php';
                    } else {
                        echo "<p>Seleccioná <strong>Suscribirse al Newsletter</strong> desde la barra superior.</p>";
                    }
                } else {
                    echo "<p>Acceso no autorizado.</p>";
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

