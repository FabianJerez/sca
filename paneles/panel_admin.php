<?php
    session_start();
    // Verificar si el usuario está autenticado
    if (!isset($_SESSION["usuario_id"])) {
        header("Location: ../login/login.php");
        exit();
    }

    include("../conection/conexion.php");

    $sql = "SELECT * FROM datos_recibe ORDER BY fecha DESC LIMIT 3";
    $resultado = $base->prepare($sql);
    $resultado->execute(array());
    
    foreach($resultado as $fila):
        $temperatura = $fila['temperatura']; 
        $humedad = $fila['humedad'];
    endforeach;  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloud IOT USUARIO</title>
    <link rel="stylesheet" href="../css/headerfooter.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/panel.css">
</head>
<body>
    <?php 
    include 'headerpanel.php'; 
    ?>
    
    <nav class="navbar"> 
        <h1> Bienvenido Usuario: </h1>
        <?php echo $_SESSION["usu"]; ?>
        
    <div class="container">
        <section class="s1">Valores Actuales          
            <div class="containergrafico">
                <div class="gaugegrafico">
                    <h2>Temperatura (°C)</h2>
                    <canvas id="tempGauge" width="200" height="200"></canvas>
                    <p id="tempValue"><?php echo $temperatura; ?> °C</p>
                </div>
                <div class="gaugegrafico">
                    <h2>Humedad (%)</h2>
                    <canvas id="humGauge" width="200" height="200"></canvas>
                    <p id="humValue"><?php echo $humedad; ?> %</p>
                </div>
            </div>
        </section>
        
        <section class="s2">           
           <h1>DATOS RECIBE Prueba DATABASE</h1>
           <?php
                // esto funionaba
                $sql = "SELECT * FROM datos_recibe ORDER BY fecha DESC LIMIT 10";
                $resultado = $base->prepare($sql);
                $resultado->execute(array());
                $chip = 112;
               
                //$sql = "SELECT * FROM datos_recibe ORDER BY fecha DESC LIMIT 10 WHERE chipid = :chip";
                //$resultado = $base->prepare($sql);
                //$resultado->execute([':chip' => $chip]);
                
            ?>
        
            <table style="width:50%; border:4px solid red; align: center;">
                <tr>
                    <th>ID</th>
                    <th>CHIPID</th>
                    <th>RESGISTRADO</th>
                    <th>TEMPERATURA</th>
                    <th>HUMEDAD</th>
                </tr>
                <?php
                    foreach($resultado as $fila):
                ?>    
                <tr>
                    <td><?php echo $fila['id']; ?></td>
                    <td><?php echo $fila['chipid']; ?></td>
                    <td><?php echo $fila['fecha']; ?></td>
                    <td><?php echo $fila['temperatura']; ?></td>
                    <td><?php echo $fila['humedad']; ?></td>
                </tr> 
                <?php
                    endforeach;
                ?>
            </table>
            
        </section>
        
        
        <section class="s3">Agregar chip 
            <?php
            //$chipid = $_POST ['chipid'];
            //$usuario = $_POST ['usuario'];
            //$descripcion = $_POST ['descripcion'];
            //$encriptacion = $_POST ['encriptacion'];
            
            $fechacreacion = '2023-10-27 15:30:00';
            $test1 = '0';
            $test2 = '0';
            $test3 = '0';
            
            $sql = "INSERT INTO chipids (id, fechacreacion, usuario, descripcion, chipid, test1, test2, test3, encriptacion) VALUES (NULL, NOW(), :usuario, :descripcion, :chipid, :test1, :test2, :test3, :encriptacion)";
            $resultado = $base -> prepare($sql);
            $resultado ->execute(array(":usuario" => $usuario, ":descripcion" => $descripcion, ":chipid" => $chipid, ":test1" => $test1, ":test2" => $test2, ":test3" => $test3, ":encriptacion" => $encriptacion ));
            ?>
    
        </section>
        
        <section class="s4">          
            <h1>CHIPID VER DATABASE</h1>
            <?php
                include("conexion.php");
                $usuario = $_SESSION["usu"];
                $sql = "SELECT * FROM chipids WHERE usuario = :usuario";
                $resultado = $base->prepare($sql);
                $resultado->execute([':usuario' => $usuario]);
                // esto funciona tambien pero hardcodeado
                //$sql = "SELECT * FROM chipids WHERE usuario = 'daniel' ";
                //$sql = "SELECT * FROM chipids";
                //$resultado = $base ->prepare($sql);
                //$resultado ->execute(array());
            ?>   
            <table style = "width:50%; border:4px solid red; align: center;">
                <tr>
                    <th>ID</th>
                    <th>USUARIO</th>
                    <th>DESCRIPCION</th>
                    <th>CHIPID</th>
                </tr>
                <?php
                    foreach($resultado as $fila):
                ?>    
                <tr>
                   <td><?php echo  $fila['id'] ;  ?>            </td>
                   <td><?php echo  $fila['usuario'];   ?>       </td>
                   <td><?php echo  $fila['descripcion'];   ?>   </td>
                   <td><?php echo  $fila['chipid'];   ?>   </td>
                </tr> 
                <?php
                    endforeach;
                ?>
            </table> 
        </section>
    </div>

    <script>
        function drawGauge(canvasId, value, maxValue, unit, label) {
            const canvas = document.getElementById(canvasId);
            const ctx = canvas.getContext('2d');
            const centerX = canvas.width / 2;
            const centerY = canvas.height / 2;
            const radius = canvas.width / 2 - 20;

            // Fondo del indicador
            ctx.beginPath();
            ctx.arc(centerX, centerY, radius, Math.PI, 2 * Math.PI, false);
            ctx.lineWidth = 20;
            ctx.strokeStyle = '#ddd';
            ctx.stroke();

            // Arco de progreso
            const progress = (value / maxValue) * Math.PI;
            ctx.beginPath();
            ctx.arc(centerX, centerY, radius, Math.PI, Math.PI + progress, false);
            ctx.strokeStyle = canvasId === 'tempGauge' ? '#ff4d4d' : '#4d79ff';
            ctx.stroke();

            // Texto en el centro
            ctx.font = '20px Arial';
            ctx.fillStyle = '#333';
            ctx.textAlign = 'center';
            ctx.fillText(label, centerX, centerY + 50);
        }

        // Dibujar indicadores
        drawGauge('tempGauge', <?php echo $temperatura; ?>, 50, '°C', 'Temperatura');
        drawGauge('humGauge', <?php echo $humedad; ?>, 100, '%', 'Humedad');
    </script>

</body>
</html>