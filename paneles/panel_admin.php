<?php
session_start();
// Verificar si el usuario está autenticado
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login/login.php");
    exit();
}

include("../conection/conexion.php");

// Obtener chipid seleccionado (si existe)
$chipid = isset($_GET['chipid']) && $_GET['chipid'] !== '' ? filter_var($_GET['chipid'], FILTER_SANITIZE_STRING) : null;

// Obtener el último registro para los indicadores
try {
    if ($chipid) {
        $sql = "SELECT temperatura, humedad FROM datos_recibe WHERE chipid = :chipid ORDER BY fecha DESC LIMIT 1";
        $resultado = $base->prepare($sql);
        $resultado->execute([':chipid' => $chipid]);
        $ultimo_registro = $resultado->fetch(PDO::FETCH_ASSOC);
    }else{
        echo "Aun no selecciono un CHIP ID";
    }

    if ($ultimo_registro) {
        $temperatura = $ultimo_registro['temperatura'];
        $humedad = $ultimo_registro['humedad'];
    } else {
        $temperatura = "No hay datos";
        $humedad = "No hay datos";
    }
    
} catch (PDOException $e) {
    $temperatura = 0;
    $humedad = 0;
    $error = "Error al consultar ultimo datos_recibe: " . htmlspecialchars($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloud IOT - Panel de Usuario</title>
    <link rel="stylesheet" href="../css/headerfooter.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/panel_admin.css">
</head>
<body>
    <?php include 'headerpanel.php'; ?>

    <nav class="navbar">
        <h1>Bienvenido Usuario: <?php echo htmlspecialchars($_SESSION["usu"]); ?></h1>
    </nav>

    <div class="container">
        <section class="s1">
            <h2>Ultimos Valores</h2>
            
            <div class="containergrafico">
                <div class="gaugegrafico">
                    <h3>Temperatura (°C)</h3>
                    
                    <canvas id="tempGauge" width="200" height="200"></canvas>
                    <p id="tempValue"><?php echo htmlspecialchars($temperatura); ?> °C</p>
                </div>
                <div class="gaugegrafico">
                    <h3>Humedad (%)</h3>
                    
                    <canvas id="humGauge" width="200" height="200"></canvas>
                    <p id="humValue"><?php echo htmlspecialchars($humedad); ?> %</p>
                </div>
            </div>
        </section>

        <section class="s2">
            <h2>Datos Recientes (Últimos 20)</h2>
            
            <?php
            try {
                if ($chipid) {
                    echo "Datos del CHIP ID = " . $chipid;
                    
                    $sql = "SELECT id, chipid, fecha, temperatura, humedad FROM datos_recibe WHERE chipid = :chipid ORDER BY fecha DESC LIMIT 20";
                    $resultado = $base->prepare($sql);
                    $resultado->execute([':chipid' => $chipid]);
                    $datos = $resultado->fetchAll(PDO::FETCH_ASSOC);
                }else{
                    echo "Aun no selecciono un CHIP ID";
                }
            ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>CHIPID</th>
                    <th>FECHA</th>
                    <th>TEMPERATURA</th>
                    <th>HUMEDAD</th>
                </tr>
                <?php if (empty($datos)): ?>
                    <tr><td colspan="5">No hay datos disponibles.</td></tr>
                <?php else: ?>
                    <?php foreach ($datos as $fila): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($fila['id']); ?></td>
                            <td><?php echo htmlspecialchars($fila['chipid']); ?></td>
                            <td><?php echo htmlspecialchars($fila['fecha']); ?></td>
                            <td><?php echo htmlspecialchars($fila['temperatura']); ?> °C</td>
                            <td><?php echo htmlspecialchars($fila['humedad']); ?> %</td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
            <?php
            } catch (PDOException $e) {
                echo "<p class='error'>Error al consultar datos_recibe: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
            ?>
        </section>

        <section class="s3">
            <h2>Funciones</h2>
            
            <div class="actions">
                <a href="<?php echo $chipid ? '../iot/chipid_modificar_salidas.php?chipid=' . urlencode($chipid) : '#'; ?>" 
                   class="action-btn" 
                   
                <?php echo !$chipid ? 'onclick="alert(\'Por favor, selecciona un ChipID primero.\'); return false;"' : ''; ?>>Manejar Salidas</a>
                
                <li><a href="../newsletter\form_newsletter.php">NEWSLETTER</a></li>
                
                <a href="../mensajes/formulario.php" class="action-btn">Bandeja de Mensajería</a>
                
                
                
                </div>
        </section>

        <section class="s4">
            <h2>Chips Asociados</h2>
            
            <?php
            try {
                $usuario = $_SESSION["usu"];
                
                $sql = "SELECT id, usuario, descripcion, chipid FROM chipids WHERE usuario = :usuario";
                $resultado = $base->prepare($sql);
                $resultado->execute([':usuario' => $usuario]);
                
                $chips = $resultado->fetchAll(PDO::FETCH_ASSOC);
            ?>
            
            <form method="get" class="filter-form">
                <label for="chipid">Seleccionar ChipID:</label>
                
                <select name="chipid" id="chipid">
                    <option value="">Todos</option>
                    <?php foreach ($chips as $chip): ?>
                        <option value="<?php echo htmlspecialchars($chip['chipid']); ?>" <?php echo $chipid === (string)$chip['chipid'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($chip['descripcion'] . ' (' . $chip['chipid'] . ')'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Filtrar</button>
            </form>
            <table>
                <tr>
                    <th>ID</th>
                    <th>USUARIO</th>
                    <th>DESCRIPCIÓN</th>
                    <th>CHIPID</th>
                </tr>
                <?php if (empty($chips)): ?>
                    <tr><td colspan="4">No hay chips asociados.</td></tr>
                <?php else: ?>
                    <?php foreach ($chips as $fila): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($fila['id']); ?></td>
                            <td><?php echo htmlspecialchars($fila['usuario']); ?></td>
                            <td><?php echo htmlspecialchars($fila['descripcion']); ?></td>
                            <td><?php echo htmlspecialchars($fila['chipid']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
            <?php
            } catch (PDOException $e) {
                echo "<p class='error'>Error al consultar chipids: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
            ?>
        </section>
    </div>

    <script>
        function drawGauge(canvasId, value, maxValue, unit, label) {
            const canvas = document.getElementById(canvasId);
            const ctx = canvas.getContext('2d');
            const centerX = canvas.width / 2;
            const centerY = canvas.height / 2;
            const radius = canvas.width / 2 - 20;

            ctx.beginPath();
            ctx.arc(centerX, centerY, radius, Math.PI, 2 * Math.PI, false);
            ctx.lineWidth = 20;
            ctx.strokeStyle = '#ddd';
            ctx.stroke();

            const progress = (value / maxValue) * Math.PI;
            ctx.beginPath();
            ctx.arc(centerX, centerY, radius, Math.PI, Math.PI + progress, false);
            ctx.strokeStyle = canvasId === 'tempGauge' ? '#ff4d4d' : '#4d79ff';
            ctx.stroke();

            ctx.font = '20px Arial';
            ctx.fillStyle = '#333';
            ctx.textAlign = 'center';
            ctx.fillText(label, centerX, centerY + 50);
        }

        drawGauge('tempGauge', <?php echo json_encode($temperatura); ?>, 50, '°C', 'Temperatura');
        drawGauge('humGauge', <?php echo json_encode($humedad); ?>, 100, '%', 'Humedad');
    </script>
</body>
</html>