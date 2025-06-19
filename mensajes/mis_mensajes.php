<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
requireLogin();

$usuario_nombre = $_SESSION["usuario_nombre"];
$email_usuario = $_SESSION["email"];

// Traemos solo los mensajes del usuario actual (por email)
$stmt = $conn->prepare("SELECT * FROM mensajes WHERE email = ? ORDER BY fecha DESC");
$stmt->execute([$email_usuario]);
$mensajes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Mis mensajes enviados</h2>

<table border="1" cellpadding="6">
    <tr>
        <th>Asunto</th>
        <th>Mensaje</th>
        <th>Estado</th>
        <th>Respuesta</th>
        <th>Fecha</th>
    </tr>

    <?php if (count($mensajes) > 0): ?>
        <?php foreach ($mensajes as $fila): ?>
            <tr>
                <td><?= htmlspecialchars($fila['asunto']) ?></td>
                <td><?= nl2br(htmlspecialchars($fila['mensaje'])) ?></td>
                <td class="<?= $fila['estado'] === 'Resuelto' ? 'resuelto' : 'pendiente'; ?>">
                    <?= htmlspecialchars($fila['estado']) ?>
                </td>
                <td><?= !empty($fila['respuesta']) ? nl2br(htmlspecialchars($fila['respuesta'])) : 'Sin respuesta' ?></td>
                <td><?= date("d/m/Y H:i", strtotime($fila['fecha'])) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="5">No enviaste mensajes aún.</td></tr>
    <?php endif; ?>
</table>

