<?php
require_once __DIR__ . '/../includes/db.php';

// Obtenemos el último registro de temperatura y humedad
$sql = "SELECT temperatura, humedad, fecha FROM datos_recibe ORDER BY fecha DESC LIMIT 1";
$stmt = $conn->query($sql);
$datos = $stmt->fetch(PDO::FETCH_ASSOC);

$temperatura = $datos['temperatura'] ?? 0;
$humedad = $datos['humedad'] ?? 0;
$fecha = $datos['fecha'] ?? 'Sin datos';
?>

<h2>Valores Actuales</h2>

<div style="display: flex; gap: 40px; justify-content: center; margin-top: 30px;">
    <div class="gaugegrafico">
        <h3>Temperatura (°C)</h3>
        <canvas id="tempGauge" width="200" height="200"></canvas>
        <p id="tempValue"><?= htmlspecialchars($temperatura) ?> °C</p>
    </div>
    <div class="gaugegrafico">
        <h3>Humedad (%)</h3>
        <canvas id="humGauge" width="200" height="200"></canvas>
        <p id="humValue"><?= htmlspecialchars($humedad) ?> %</p>
    </div>
</div>

<p style="text-align: center; margin-top: 20px;">Última actualización: <?= htmlspecialchars($fecha) ?></p>

<script>
function drawGauge(canvasId, value, maxValue, label) {
    const canvas = document.getElementById(canvasId);
    const ctx = canvas.getContext('2d');
    const centerX = canvas.width / 2;
    const centerY = canvas.height / 2;
    const radius = canvas.width / 2 - 20;

    // Fondo
    ctx.beginPath();
    ctx.arc(centerX, centerY, radius, Math.PI, 2 * Math.PI);
    ctx.lineWidth = 20;
    ctx.strokeStyle = '#ccc';
    ctx.stroke();

    // Valor actual
    const angle = (value / maxValue) * Math.PI;
    ctx.beginPath();
    ctx.arc(centerX, centerY, radius, Math.PI, Math.PI + angle);
    ctx.strokeStyle = canvasId === 'tempGauge' ? '#ff4d4d' : '#4d79ff';
    ctx.stroke();

    // Etiqueta
    ctx.font = '16px Arial';
    ctx.fillStyle = '#333';
    ctx.textAlign = 'center';
    ctx.fillText(label, centerX, centerY + 50);
}

drawGauge('tempGauge', <?= $temperatura ?>, 50, 'Temperatura');
drawGauge('humGauge', <?= $humedad ?>, 100, 'Humedad');
</script>
