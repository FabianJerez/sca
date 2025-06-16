<?php
session_start();

// Validar sesión y verificamos que el usuario este logueado
if (!isset($_SESSION["usuario_id"])) {
    // El usuario no está logueado → lo mandamos al login
    header("Location: ../login/login.html");
    exit;
}

// Conectamos a la base de datos
require("conexion.php");

// Obtenemos los mensajes filtrando los resueltos o los pendientes
$estado_filtro = $_GET['estado'] ?? '';

if ($estado_filtro === 'Pendiente' || $estado_filtro === 'Resuelto') {
    $stmt = $conexion->prepare("SELECT * FROM mensajes WHERE estado = ? ORDER BY fecha DESC");
    $stmt->bind_param("s", $estado_filtro);
    $stmt->execute();
    $resultado = $stmt->get_result();
} else {
    $resultado = $conexion->query("SELECT * FROM mensajes ORDER BY fecha DESC");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mensajes Recibidos</title>
    <link rel="stylesheet" href="../css/ver_mensajes.css">

</head>
<body>

    <h2>Mensajes Recibidos</h2>
    <p>Usuario logueado: <strong><?php echo htmlspecialchars($_SESSION["usuario_nombre"]); ?></strong></p>
    <a href="../login/logout.php">Cerrar sesión</a>

    <form method="get" action="ver_mensajes.php">
        <label for="estado">Filtrar por estado:</label>
        <select name="estado" id="estado">
            <option value="">-- Todos --</option>
            <option value="Pendiente" <?php if ($_GET['estado'] ?? '' === 'Pendiente') echo 'selected'; ?>>Pendiente</option>
            <option value="Resuelto" <?php if ($_GET['estado'] ?? '' === 'Resuelto') echo 'selected'; ?>>Resuelto</option>
        </select>
        <button type="submit">Aplicar</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>remitente</th>
            <th>Asunto</th>
            <th>Email</th>
            <th>Mensaje</th>
            <th>Archivo</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th>Responder</th>
            <th>Respuesta</th>
        </tr>

        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?php echo $fila['id']; ?></td>
                <td><?php echo htmlspecialchars($fila['remitente']); ?></td>
                <td><?php echo htmlspecialchars($fila['asunto']); ?></td>
                <td><?php echo htmlspecialchars($fila['email']); ?></td>
                <td><?php echo nl2br(htmlspecialchars($fila['mensaje'])); ?></td>
                <td>
                    <?php
                    if (!empty($fila['archivo_nombre'])) {
                        echo "<a href='../uploads/" . urlencode($fila['archivo_nombre']) . "' target='_blank'>Ver archivo</a>";
                    } else {
                        echo "—";
                    }
                    ?>
                </td>
                <td class="<?php echo $fila['estado'] === 'Resuelto' ? 'estado-resuelto' : 'estado-pendiente'; ?>">
                    <?php
                    if ($fila['estado'] === 'Resuelto') {
                        echo "Resuelto";
                    } else {
                        echo '<a href="cambiar_estado.php?id=' . $fila['id'] . '">Marcar como Resuelto</a>';
                    }
                    ?>
                </td>
                <td><?php echo $fila['fecha']; ?></td>
                <td><a href="responder.php?id=<?php echo $fila['id']; ?>">Responder</a></td>
                <td><?php echo !empty($fila['respuesta']) ? nl2br(htmlspecialchars($fila['respuesta'])) : '—'; ?></td>
            </tr>
        <?php endwhile; ?>

    </table>

</body>
</html>

<?php
$conexion->close();
?>