<?php
// Asegurarse de que esté definido $base y $_SESSION['usu'] en panel.php

$chipid = isset($_GET['chipid']) && $_GET['chipid'] !== '' 
    ? filter_var($_GET['chipid'], FILTER_SANITIZE_STRING) 
    : null;

$datos = [];
$error = null;

if ($chipid) {
    try {
        $sql = "SELECT id, chipid, fecha, temperatura, humedad 
                FROM datos_recibe 
                WHERE chipid = :chipid 
                ORDER BY fecha DESC 
                LIMIT 20";
        $stmt = $base->prepare($sql);
        $stmt->execute([':chipid' => $chipid]);
        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = "Error al consultar registros recientes: " . htmlspecialchars($e->getMessage());
    }
}
?>

<section class="s2">
    <h2>Registros Recientes</h2>

    <?php if ($chipid): ?>
        <p>Mostrando datos del CHIP ID: <strong><?= htmlspecialchars($chipid) ?></strong></p>

        <?php if (!empty($datos)): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>CHIPID</th>
                    <th>FECHA</th>
                    <th>TEMPERATURA (°C)</th>
                    <th>HUMEDAD (%)</th>
                </tr>
                <?php foreach ($datos as $fila): ?>
                    <tr>
                        <td><?= htmlspecialchars($fila['id']) ?></td>
                        <td><?= htmlspecialchars($fila['chipid']) ?></td>
                        <td><?= htmlspecialchars($fila['fecha']) ?></td>
                        <td><?= htmlspecialchars($fila['temperatura']) ?> °C</td>
                        <td><?= htmlspecialchars($fila['humedad']) ?> %</td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No se encontraron registros para este ChipID.</p>
        <?php endif; ?>
    <?php else: ?>
        <p>Por favor, selecciona un ChipID para ver los registros recientes.</p>
    <?php endif; ?>

    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>
</section>
