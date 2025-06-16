<?php
echo "insertar del login";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $usuario = $_POST["usuario"] ?? '';
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';
    
    echo "<br>";
    echo $usuario;
    echo "<br>";
    echo $email;
    echo "<br>";
    echo $password;
    
    if (!$usuario || !$email || !$password) {
        echo "Todos los campos son obligatorios.";
        //exit;
        }else{
            echo "Todos los campos estan completos.";
            // Buscamos el usuario en la base
            
            echo "<br>";
            echo "select4";
            
            include("conexion.php");
            //$sql = "SELECT * FROM usuarios";
            $sql = "SELECT * FROM usuarios WHERE usuario = :usuario OR email = :email";
            $resultado = $base ->prepare($sql);
            $resultado ->execute(array(":usuario" => $usuario, ":email" => $email));
            //$resultado ->execute(array());
        
           
            foreach($resultado as $fila):
                echo "<br>";
                echo "foreach";
        
                if ($fila > 0 ) {  
                    
                    echo  $fila["id"];
                    echo "<br>";
                    echo  $fila["usuario"];
                    echo "<br>";
                    echo  $fila["email"];
                    echo "<br>";
            
                    echo "❌ El usuario o email ya están registrados.";        
                    exit;
                }
            endforeach;
            
            
            echo "<br>";
            echo "el usuario es nuevo, insertarlo";
            
            $hash_password = password_hash($password, PASSWORD_DEFAULT); // encripta
                // Por defecto, todos los que se registran son usuarios comunes
            $rol = "usuario";
            echo "<br>";
            echo $hash_password;
            echo "<br>";
            echo $rol;                                                                              //hasta aqui llega ok
                    
            $sql = "INSERT INTO usuarios (id, usuario, password, hash_password, email, estado, fecha_inicio, rol) VALUES (NULL, :usuario, :password, :hash_password, :email, '1', CURRENT_TIMESTAMP, :rol)";
        
            $resultado = $base ->prepare($sql);
            $resultado ->execute(array(":usuario" => $usuario, ":password" => $password, ":hash_password" => $hash_password, ":email" => $email, ":rol" => $rol));
            
            echo "ok";
                    
            echo "<br>";
            echo "<script>
            alert('✅ Usuario registrado correctamente.');
            window.location.href = 'login.php';
            </script>";
            exit;
        
        }


}else {
    echo "no vinieron datos por post";
    exit;
}



?>
