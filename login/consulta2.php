<?php
session_start(); // ðŸ‘‰ Iniciamos la sesiÃ³n

echo "LOGIN CONSULTA";

//include("../conection/conexion.php");
include("conexion.php");

// Obtenemos los datos del formulario
$usuario = $_POST["usuario"] ??'';
$password = $_POST["password"] ??'';

echo "<br>";
echo  $usuario;
echo "<br>";
echo  $password;
echo "<br>";

// Buscamos el usuario en la base
$sql = "SELECT * FROM usuarios WHERE usuario = :usuario AND estado = 1";

$resultado = $base -> prepare($sql);
$resultado ->execute(array(":usuario" => $usuario));



foreach($resultado as $fila):

    if ($fila > 0 ) {  
            // Verificamos la contraseÃ±a
        if (password_verify($password, $fila["hash_password"])) {
            //  Login correcto  creamos la sesion
            $_SESSION["usuario_id"] = $fila["id"];
            echo  $fila["id"];
            echo "<br>";
            $_SESSION["usuario_nombre"] = $fila["usuario"];
            echo  $fila["usuario"];
            echo "<br>";
            $_SESSION["rol"] = $fila["rol"]; // el rol es "usuario" o "admin"
            echo  $fila["rol"];
            echo "<br>";
            $_SESSION["email"] = $fila["email"];
            echo $fila["email"];
            echo "<br>";
            var_dump($_SESSION["rol"]);
            
            session_start();
              
            //  al panel de administrador
            $redirect = $_POST["redirect"] ?? '';
            echo "redirect: " . $redirect;
            
            echo "<script>
            alert('✅ Ingreso CORRECTO.');
            window.location.href = 'login.php';
            </script>";
            

            if (!empty($redirect) && str_starts_with($redirect, "../")) {
                echo "salio por aqui 1";
            } else {
                echo "salio por aqui 2";
                header("Location: ../" . (strtolower(trim($_SESSION["rol"])) === "admin" ? "paneles/panel_admin.php" : "paneles/panel_usuario.php"));
                
                echo "Redirigiendo a: " . $destino;
                //exit;
            }
            //exit;     

        } else {
            header("Location: login.php?error=1");  //mensajes de error..si el passwor dio mal
            echo "salio por aqui 3";
            //exit;
        }

    } else {
        header("Location: login.php?error=1");
        echo "salio por aqui 4";
        //exit;
    }


endforeach;

?>
