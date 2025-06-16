
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>ACTUALIZAR DATOS</h1>
    <?php
        include("conexion.php");
                                        //si no se apreto ACTULIZAR
        if (!isset($_POST['up'])){// lo que hay dentro del campo up que es el button
        
            $id = $_GET['id'];        
            $user = $_GET['user']; 
            $pas = $_GET['pas'];
            $hash = $_GET['hash'];
        }else{
            $id = $_POST['id'];        
            $user = $_POST['user']; 
            $pas = $_POST['pas'];
            $hash = $_POST['hash'];            

            $sql= "UPDATE datos_usuarios SET usuarios=:user, password=:pas WHERE id_usuarios= :id";
            
            $resultado = $base ->prepare($sql);
            $resultado ->execute(array(":id" =>$id ,":user" =>$user, ":pas" =>$pas));      
            header("Location:index.php");  //para que vuelva al index
            }
    ?>

    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <table  style = "width:50%; border:4px solid red; align: center;">
            <tr>
                <th>
                    <label for="id">ID</label> 
                </th>
                <td>
                    <input type="text" readonly name="id" id="id" value= <?php echo $id; ?>>
                </td>                
            </tr>
            <tr>
                <th>
                    <label for="id">USUARIO</label> 
                </th>
                <td>
                    <input type="text" name="user" id="user" value= <?php echo $user; ?>>
                </td>                
            </tr>
            <tr>
                <th>
                    <label for="id">CONTRASEÑA</label> 
                </th>
                <td>
                    <input type="text" name="pas" id="pas" value= <?php echo $pas; ?>>
                </td>                
            </tr>
            <tr>
                <th>
                    <label for="id">CONTRASEÑA CEIFRADA</label> 
                </th>
                <td>
                    <input type="text" name="hash" id="hash" value= <?php echo $hash; ?>>
                </td>                
            </tr>

            <tr >
                <td colpan=2>
                    <button></button>
                    <input type="submit" value= "modificar" name=up>
                </td>                
            </tr>
            <tr >
                <td colpan=2>
                    <a href="index.php">VOLVER</a>
                </td>                
            </tr>
    
        </table>


    </form>
    
</body>
</html>