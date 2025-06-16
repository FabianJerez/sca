<?php
include("conexion.php");
$id = $_GET["id"];
$base ->query("DELETE FROM datos_usuarios WHERE id_usuarios = '$id' "  );
header("Location:index.php");

?>
