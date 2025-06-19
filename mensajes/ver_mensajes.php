<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificamos que el usuario esté logueado
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login/login.php");
    exit;
}

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../config.php'; // Para BASE_URL

$estado_filtro = $_GET['estado'] ?? '';

if ($estado_filtro === 'Pendiente' || $estado_filtro === 'Resuelto') {
    $stmt = $conn->prepare("SELECT * FROM mensajes WHERE estado = ? ORDER BY fecha DESC");
    $stmt->execute([$estado_filtro]);
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
<p>Usuario logueado: <strong><?= htmlspecialchars($_SESSION["usuario_nombre"]) ?></strong></p>

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
        <th>Remitente</th>
        <th>Asunto</th>
        <th>Email</th>
        <th>Mensaje</th>
        <th>Archivo</th>
        <th>Estado</th>
        <th>Fecha</th>
        <th>Responder</th>
        <th>Respuesta</th>
    </tr>

    <?php while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) : ?>
        <tr>
            <td><?= $fila['id'] ?></td>
            <td><?= htmlspecialchars($fila['remitente']) ?></td>
            <td><?= htmlspecialchars($fila['asunto']) ?></td>
            <td><?= htmlspecialchars($fila['email']) ?></td>
            <td><?= nl2br(htmlspecialchars($fila['mensaje'])) ?></td>
            <td>
                <?php if (!empty($fila['archivo_nombre'])): ?>
                    <a href="../uploads/<?= urlencode($fila['archivo_nombre']) ?>" target="_blank">Ver archivo</a>
                <?php else: ?>
                    —
                <?php endif; ?>
            </td>
            <td class="<?= $fila['estado'] === 'Resuelto' ? 'estado-resuelto' : 'estado-pendiente' ?>">
                <?php if ($fila['estado'] === 'Resuelto'): ?>
                    Resuelto
                <?php else: ?>
                    <a href="cambiar_estado.php?id=<?= $fila['id'] ?>">Marcar como Resuelto</a>
                <?php endif; ?>
            </td>
            <td><?= $fila['fecha'] ?></td>
            <td>
                <a href="<?= BASE_URL ?>panel.php?seccion=mensajes&sub=responder&id=<?= $fila['id'] ?>">Responder</a>
            </td>
            <td><?= !empty($fila['respuesta']) ? nl2br(htmlspecialchars($fila['respuesta'])) : '—' ?></td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
