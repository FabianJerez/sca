<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN Prueba DATABASE</title>
</head>
<body>
    <h1>LOGIN Prueba DATABASE</h1>
    <?php
        include("conexion.php");
        $sql = "SELECT * FROM datos_usuarios";
        $resultado = $base ->prepare($sql);
        $resultado ->execute(array());

             

        if(isset($_POST["cr"]))   //si se seteo....y se cual fue como si fuera post..de un archivo a otro
            {
                $nombre = $_POST["user"];
                $pas = $_POST["pas"];
                $sql = "INSERT INTO datos_usuarios(usuarios, password) VALUES (:user,:pas)";

                $resultado = $base -> prepare($sql);
                $resultado ->execute(array(":user" => $nombre , ":pas" => $pas ));  //las flechitas es que VA A LLAMAR a quien executara
            
            
            
            }
                                                               // a la varible tipo : enmascarada  le pongo lo que tengo en la varibla $
            ?>

    <h1>Tabla para un CRUD</h1>
    
    <h1>tenemos el create y el read</h1>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method = "post"> 
    <!-- server se llama a si mismo para que sea mas seguro
        para que se resuelva en este mismo archivo php sin intermediarios-->
        <table style = "width:50%; border:4px solid red; align: center;">
            <tr>
                <th>ID</th>
                <th>USUARIO</th>
                <th>PASSWORD</th>
                <th>HASH</th>
                <th>ACCIONES</th>
            </tr>
            <?php
            foreach($resultado as $fila):
            ?>    
            <tr>
               <td><?php echo  $fila['id_usuarios'] ;  ?> </td>
               <td><?php echo  $fila['usuarios'];   ?> </td>
               <td><?php echo  $fila['password'];   ?> </td>
               <td><?php echo  $fila['hash_password'];   ?> </td>
               <td>
                    <a href="borrar.php?id=<?php echo $fila['id_usuarios']?>">
                        <input type="button" value="borrar" name='del'>
                        <img src="img/papelera.png" width=30px alt="">
                    </a>
               </td>
               <td>
                    <a href="editar.php?id=<?php echo $fila['id_usuarios']?> & user=<?php echo $fila['usuarios']?> & pas=<?php echo $fila['password']?> & hash=<?php echo $fila['hash_password']?>" >
                        <!-- vijan por la url los datos y con metodo get -->
                        <input type="button" value="actualizar" name='up'>
                        <img src="img/actualizar.png" width=30px alt="">
                    </a>
               </td>               
            </tr>

            <?php
                endforeach;
            ?>

            <tr>
                <td>
                    
                </td>
                <td>
                    <input type="text" name="user" id="user">
                </td>
                <td>
                    <input type="text" name="pas" id="pas">
                </td>
                <td>
                    <input type="hash" name="hash" id="hash">
                </td>
                <td>
                    <input type="submit" value="guardar" name="cr" id="cr">
                    <button type="submit" name="cr" id="cr">
                        <img src="img/insertar.png" width=30px alt="">                        
                    </button>

                </td>
            </tr>
        </table>
    </form> 

</body>
</html>