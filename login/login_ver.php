<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN VER TODOS</title>
</head>
<body>
    
    <h1>LOGIN VER TODOS en DB</h1>


    <?php
        include("conexion.php");
        $sql = "SELECT * FROM usuarios";
        $resultado = $base ->prepare($sql);
        $resultado ->execute(array());
    ?>    

    <table style = "width:50%; border:4px solid red; align: center;"> 
        <tr> 
            <th>ID                  </th> 
            <th>USUARIO             </th> 
            <th>PASSWORD            </th> 
            <th>HASH_PASSWORD       </th> 
            <th>EMAIL               </th> 
            <th>ESTADO              </th> 
            <th>FECHA_INICIO        </th> 
            <th>ROL                 </th> 
        </tr> 
        <?php foreach($resultado as $fila): ?> 
        <tr> 
            <td><?php echo $fila['id'] ; ?>             </td> 
            <td><?php echo $fila['usuario']; ?>         </td> 
            <td><?php echo $fila['password']; ?>        </td> 
            <td><?php echo $fila['hash_password']; ?>   </td> 
            <td><?php echo $fila['email']; ?>           </td> 
            <td><?php echo $fila['estado']; ?>          </td> 
            <td><?php echo $fila['fecha_inicio']; ?>    </td> 
            <td><?php echo $fila['rol']; ?>             </td> 
        </tr> 
        <?php endforeach; ?> 
    </table> 
</body> 
</html>