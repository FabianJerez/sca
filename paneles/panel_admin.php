<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION["usuario_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: ../login/login.php");
    exit();
}

// Últimos datos del sensor
$sql = "SELECT * FROM datos_recibe ORDER BY fecha DESC LIMIT 3";
$stmt = $base->prepare($sql);
$stmt->execute();
$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
$temperatura = $datos[0]['temperatura'] ?? 0;
$humedad = $datos[0]['humedad'] ?? 0;

// Lista de usuarios
$sqlUsuarios = "SELECT id, usuario, email, rol, estado, fecha_inicio FROM usuarios";
$stmtUsuarios = $base->prepare($sqlUsuarios);
$stmtUsuarios->execute();
$usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin</title>
    <link rel="stylesheet" href="../css/headerfooter.css">
    <link rel="stylesheet" href="../css/panel.css">
</head>
<body>
    <?php include 'headerpanel.php'; ?>

    <h1>Panel del Administrador</h1>
    <p>Bienvenido, <strong><?= htmlspecialchars($_SESSION["usuario_nombre"]) ?></strong></p>

    <section>
        <h2>Últimos datos del sensor</h2>
        <p>Temperatura actual: <strong><?= $temperatura ?> °C</strong></p>
        <p>Humedad actual: <strong><?= $humedad ?> %</strong></p>
    </section>

    <section>
        <h2>Gestión de usuarios</h2>
        <table border="1" cellpadding="5">
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Fecha Inicio</th>
                <th>Acción</th>
            </tr>
            <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= htmlspecialchars($u['usuario']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td><?= $u['rol'] ?></td>
                <td><?= $u['estado'] == 1 ? 'Activo' : 'Inactivo' ?></td>
                <td><?= $u['fecha_inicio'] ?></td>
                <td>
                    <form action="cambiar_rol.php" method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $u['id'] ?>">
                        <input type="hidden" name="rol_actual" value="<?= $u['rol'] ?>">
                        <button type="submit">Cambiar Rol</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </section>

    <?php
    // Obtener mensajes
    $sqlMensajes = "SELECT m.id, m.nombre, m.email, m.mensaje, m.fecha, u.usuario 
                    FROM mensajes m
                    LEFT JOIN usuarios u ON m.usuario_id = u.id
                    ORDER BY m.fecha DESC";
    $stmtMensajes = $base->prepare($sqlMensajes);
    $stmtMensajes->execute();
    $mensajes = $stmtMensajes->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <section>
        <h2>Mensajes de Contacto</h2>
        <?php if (count($mensajes) > 0): ?>
            <table border="1" cellpadding="5">
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Mensaje</th>
                    <th>Fecha</th>
                </tr>
                <?php foreach ($mensajes as $msg): ?>
                <tr>
                    <td><?= $msg['id'] ?></td>
                    <td><?= htmlspecialchars($msg['usuario'] ?? 'No logueado') ?></td>
                    <td><?= htmlspecialchars($msg['nombre']) ?></td>
                    <td><?= htmlspecialchars($msg['email']) ?></td>
                    <td><?= htmlspecialchars($msg['mensaje']) ?></td>
                    <td><?= $msg['fecha'] ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No hay mensajes registrados.</p>
        <?php endif; ?>
    </section>


</body>
</html>
