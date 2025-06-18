<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//verificamos que el usuario este logueado, si no lo está → lo mandamos al login
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login/login.html");
    exit;
}

// Conectamos a la base de datos
require_once __DIR__ . '/../includes/db.php';

// Obtenemos los mensajes filtrando los resueltos o los pendientes
$estado_filtro = $_GET['estado'] ?? '';

if ($estado_filtro === 'Pendiente' || $estado_filtro === 'Resuelto') {
    $stmt = $conn->prepare("SELECT * FROM mensajes WHERE estado = ? ORDER BY fecha DESC");
    $stmt->execute([$estado_filtro]); // ✅ Se pasa el parámetro
    $resultado = $stmt;
} else {
    $resultado = $conn->query("SELECT * FROM mensajes ORDER BY fecha DESC");
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

    <form method="get" action="<?= BASE_URL ?>panel.php">
        <input type="hidden" name="seccion" value="mensajes">
        <input type="hidden" name="sub" value="ver">
        <label for="estado">Filtrar por estado:</label>
        <select name="estado" id="estado">
            <option value="">-- Todos --</option>
            <option value="Pendiente" <?= ($_GET['estado'] ?? '') === 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
            <option value="Resuelto" <?= ($_GET['estado'] ?? '') === 'Resuelto' ? 'selected' : '' ?>>Resuelto</option>
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

        <?php while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)): ?>
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
                <td><a href="../panel.php?seccion=mensajes&id=<?= $fila['id'] ?>">Responder</a></td>
                <td><?php echo !empty($fila['respuesta']) ? nl2br(htmlspecialchars($fila['respuesta'])) : '—'; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>