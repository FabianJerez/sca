<?php
require_once __DIR__ . '/../includes/db.php';

// Obtener los últimos 10 registros
$sql = "SELECT chipid, temperatura, humedad, fecha FROM datos_recibe ORDER BY fecha DESC LIMIT 10";
$stmt = $conn->query($sql);
$registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Últimos registros recibidos</h2>

<table border="1" cellpadding="5" cellspacing="0" style="margin-top: 20px; width: 100%; max-width: 800px;">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Chip ID</th>
            <th>Temperatura (°C)</th>
            <th>Humedad (%)</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($registros) === 0): ?>
            <tr><td colspan="4">No hay registros disponibles.</td></tr>
        <?php else: ?>
            <?php foreach ($registros as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['fecha']) ?></td>
                    <td><?= htmlspecialchars($r['chipid']) ?></td>
                    <td><?= htmlspecialchars($r['temperatura']) ?></td>
                    <td><?= htmlspecialchars($r['humedad']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
