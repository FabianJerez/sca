<?php
session_start(); // Iniciar sesión si es necesario para otras funcionalidades
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN Prueba DATABASE</title>
    <style>
        table {
            width: 50%;
            border: 4px solid red;
            margin: 0 auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>LOGIN Prueba DATABASE</h1>

    <?php
    try {
        include("conexion.php");
        $sql = "SELECT * FROM datos_recibe";
        $resultado = $base->prepare($sql);
        $resultado->execute();
        $filas = $resultado->fetchAll(PDO::FETCH_ASSOC);

        if ($resultado->rowCount() == 0) {
            echo "<p>No hay datos en la tabla datos_recibidos</p>";
        }
    } catch (PDOException $e) {
        echo "Error en la consulta: " . $e->getMessage() . "<br>";
        echo "Línea de error: " . $e->getLine();
        exit();
    }
    ?>

    <table>
        <tr>
            <th>ID</th>
            <th>CHIPID</th>
            <th>FECHA</th>
            <th>TEMPERATURA</th>
        </tr>
        <?php foreach ($filas as $fila): ?>
        <tr>
            <td><?php echo htmlspecialchars($fila['id']); ?></td>
            <td><?php echo htmlspecialchars($fila['chipId']); ?></td>
            <td><?php echo htmlspecialchars($fila['fecha']); ?></td>
            <td><?php echo htmlspecialchars($fila['temperatura']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>       
</body>
</html>