<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHIPID VER</title>
</head>
<body>
    
    <h1>CHIPID VER DATABASE</h1>


    <?php
        include("conexion.php");
        $sql = "SELECT * FROM chipids";
        $resultado = $base ->prepare($sql);
        $resultado ->execute(array());
    ?>    

    <table style = "width:50%; border:4px solid red; align: center;">
        <tr>
            <th>ID</th>
            <th>FECHA CREACION</th>
            <th>USUARIO</th>
            <th>DESCRIPCION</th>
            <th>HUMEDAD</th>
            <th>CHIPID</th>
            <th>TEST1</th>
            <th>TEST2</th>
            <th>TEST3</th>
            <th>ENCRIPTACION</th>
        </tr>
        <?php
            foreach($resultado as $fila):
        ?>    
        <tr>
           <td><?php echo  $fila['id'] ;  ?>            </td>
           <td><?php echo  $fila['fechacreacion'];   ?> </td>
           <td><?php echo  $fila['usuario'];   ?>       </td>
           <td><?php echo  $fila['descripcion'];   ?>   </td>
           <td><?php echo  $fila['humedad'];   ?>   </td>
           <td><?php echo  $fila['chipid'];   ?>   </td>
           <td><?php echo  $fila['test1'];   ?>         </td>
           <td><?php echo  $fila['test2'];   ?>         </td>
           <td><?php echo  $fila['test3'];   ?>         </td>
           <td><?php echo  $fila['encriptacion'];   ?>  </td>
        </tr> 

        <?php
            endforeach;
        ?>

    </table>       
</body>
</html>