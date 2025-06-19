<?php
require_once __DIR__ . '/../includes/db.php';

$sql = "SELECT * FROM datos_recibe ORDER BY fecha DESC LIMIT 3";
$resultado = $conn->prepare($sql);
$resultado->execute();
$ultimos = $resultado->fetchAll(PDO::FETCH_ASSOC);

$temperatura = $ultimos[0]['temperatura'] ?? 0;
$humedad = $ultimos[0]['humedad'] ?? 0;
?>

<section class="s1">
    <h2>Valores Actuales</h2>
    <div class="containergrafico">
        <div class="gaugegrafico">
            <h3>Temperatura (°C)</h3>
            <canvas id="tempGauge" width="200" height="200"></canvas>
            <p id="tempValue"><?= $temperatura ?> °C</p>
        </div>
        <div class="gaugegrafico">
            <h3>Humedad (%)</h3>
            <canvas id="humGauge" width="200" height="200"></canvas>
            <p id="humValue"><?= $humedad ?> %</p>
        </div>
    </div>
</section>

<section class="s2">
    <h2>Últimos registros recibidos</h2>
    <?php
    $sql = "SELECT * FROM datos_recibe ORDER BY fecha DESC LIMIT 10";
    $resultado = $conn->prepare($sql);
    $resultado->execute();
    ?>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>CHIPID</th>
            <th>Fecha</th>
            <th>Temperatura</th>
            <th>Humedad</th>
        </tr>
        <?php foreach ($resultado as $fila): ?>
            <tr>
                <td><?= $fila['id'] ?></td>
                <td><?= $fila['chipid'] ?></td>
                <td><?= $fila['fecha'] ?></td>
                <td><?= $fila['temperatura'] ?></td>
                <td><?= $fila['humedad'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>

<section class="s4">
    <h2>CHIPIDs registrados</h2>
    <?php
    $usuario = $_SESSION["usu"];
    $sql = "SELECT * FROM chipids WHERE usuario = :usuario";
    $resultado = $conn->prepare($sql);
    $resultado->execute([':usuario' => $usuario]);
    ?>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Descripción</th>
            <th>CHIPID</th>
        </tr>
        <?php foreach ($resultado as $fila): ?>
            <tr>
                <td><?= $fila['id'] ?></td>
                <td><?= $fila['usuario'] ?></td>
                <td><?= $fila['descripcion'] ?></td>
                <td><?= $fila['chipid'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>

<script>
    function drawGauge(canvasId, value, maxValue, label) {
        const canvas = document.getElementById(canvasId);
        const ctx = canvas.getContext('2d');
        const centerX = canvas.width / 2;
        const centerY = canvas.height / 2;
        const radius = canvas.width / 2 - 20;

        ctx.beginPath();
        ctx.arc(centerX, centerY, radius, Math.PI, 2 * Math.PI);
        ctx.lineWidth = 20;
        ctx.strokeStyle = '#ccc';
        ctx.stroke();

        const progress = (value / maxValue) * Math.PI;
        ctx.beginPath();
        ctx.arc(centerX, centerY, radius, Math.PI, Math.PI + progress);
        ctx.strokeStyle = canvasId === 'tempGauge' ? '#ff4d4d' : '#4d79ff';
        ctx.stroke();

        ctx.font = '20px Arial';
        ctx.fillStyle = '#333';
        ctx.textAlign = 'center';
        ctx.fillText(label, centerX, centerY + 50);
    }

    drawGauge('tempGauge', <?= $temperatura ?>, 50, 'Temperatura');
    drawGauge('humGauge', <?= $humedad ?>, 100, 'Humedad');
</script>
