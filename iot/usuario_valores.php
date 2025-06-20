<?php
// Asegurarse de que esté definido $base y $_SESSION['usu'] en panel.php

// Obtener el chipid por GET
$chipid = isset($_GET['chipid']) && $_GET['chipid'] !== '' 
    ? filter_var($_GET['chipid'], FILTER_SANITIZE_STRING) 
    : null;

$temperatura = "No hay datos";
$humedad = "No hay datos";
$error = null;

if ($chipid) {
    try {
        $sql = "SELECT temperatura, humedad FROM datos_recibe 
                WHERE chipid = :chipid 
                ORDER BY fecha DESC LIMIT 1";
        $stmt = $base->prepare($sql);
        $stmt->execute([':chipid' => $chipid]);
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($datos) {
            $temperatura = $datos['temperatura'];
            $humedad = $datos['humedad'];
        }
    } catch (PDOException $e) {
        $error = "Error al consultar: " . htmlspecialchars($e->getMessage());
        $temperatura = 0;
        $humedad = 0;
    }
}
?>

<section class="s1">
    <h2>Valores actuales</h2>

    <?php if ($chipid): ?>
        <div class="containergrafico">
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
    <?php else: ?>
        <p>Por favor, selecciona un ChipID para ver los valores actuales.</p>
    <?php endif; ?>

    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>
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
    ctx.strokeStyle = '#ddd';
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

drawGauge('tempGauge', <?= json_encode($temperatura) ?>, 50, 'Temperatura');
drawGauge('humGauge', <?= json_encode($humedad) ?>, 100, 'Humedad');
</script>
