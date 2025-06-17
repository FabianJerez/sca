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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Principal</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/headerfooter.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/panel.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="panel-container">
    <!-- Barra lateral -->
    <aside class="sidebar">
        <h3>Menú</h3>
        <ul>
            <?php if ($rol === 'usuario'): ?>
                <li><a href="panel.php?vista=contenido_usuario/mis_mensajes">Mis Mensajes</a></li>
            <?php elseif ($rol === 'admin'): ?>
                <li><a href="panel.php?vista=contenido_admin/ver_mensajes">Ver Mensajes</a></li>
            <?php endif; ?>
            <!-- Otras opciones según el rol -->
            <li><a href="login/logout.php">Cerrar sesión</a></li>
        </ul>
    </aside>

    <!-- Contenido principal -->
    <main class="panel-content">
        <?php
        $ruta = __DIR__ . '/paneles/' . $vista . '.php';
        if (file_exists($ruta)) {
            include $ruta;
        } else {
            echo "<h2>Bienvenido, " . htmlspecialchars($_SESSION["usuario_nombre"]) . "</h2>";
        }
        ?>
    </main>
</div>

</body>
</html>

