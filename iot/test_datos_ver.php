<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>DATOS RECIBE  Prueba DATABASE</h1>

    <?php
        include("conexion.php");
        $sql = "SELECT * FROM datos_recibe";
        $resultado = $base ->prepare($sql);
        $resultado ->execute(array());
    ?>    

    <table style = "width:50%; border:4px solid red; align: center;">
        <tr>
            <th>ID</th>
            <th>CHIPID</th>
            <th>FECHA</th>
            <th>TEMPERATURA</th>
            <th>HUMEDAD</th>
            <th>TEST1</th>
            <th>TEST2</th>
            <th>TEST3</th>
            <th>FRIZER</th>
            <th>GAS</th>
            <th>REFRIGERADOR</th>
        </tr>
        <?php
            foreach($resultado as $fila):
        ?>    
        <tr>
           <td><?php echo  $fila['id'] ;  ?>            </td>
           <td><?php echo  $fila['chipid'];   ?>        </td>
           <td><?php echo  $fila['fecha'];   ?>         </td>
           <td><?php echo  $fila['temperatura'];   ?>   </td>
           <td><?php echo  $fila['humedad'];   ?>       </td>
           <td><?php echo  $fila['test1'];   ?>         </td>
           <td><?php echo  $fila['test2'];   ?>         </td>
           <td><?php echo  $fila['test3'];   ?>         </td>
           <td><?php echo  $fila['frizer'];   ?>        </td>
           <td><?php echo  $fila['gas'];   ?>          </td>
           <td><?php echo  $fila['refrigerador'];   ?>  </td>
        </tr> 

        <?php
            endforeach;
        ?>

    </table>       
</body>
</html>