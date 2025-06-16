<?php

$chipid = $_POST ['chipid'];
$usuario = $_POST ['usuario'];
$descripcion = $_POST ['descripcion'];
$encriptacion = $_POST ['encriptacion'];

echo "CHIPID a ser agregado : "  . $chipid;
echo "<br>";
echo "Usuario propietario: " . $usuario;
echo "<br>";
echo "Descripcion del uso: " . $descripcion;
echo "<br>";
echo "Valor para encriptacion: " . $encriptacion;
echo "<br>";

$fechacreacion = '2023-10-27 15:30:00';
$test1 = '0';
$test2 = '0';
$test3 = '0';




include("conexion.php");

echo "<br>";
echo "conexion";
echo "<br>";
//$fechacreacion = date('Y-m-d H:i:s'); // Formato: 2023-10-27 15:30:00

//$sql = "INSERT INTO chipids (fechacreacion, usuario, descripcion, chipid, test1, test2, test3, encriptacion) VALUES ( :fechacreacion, :usuario, :descripcion, :chipid, :test1, :test2, :test3, :encriptacion)";

//sql= INSERT INTO chipids (fechacreacion, usuario, descripcion, chipid, test1, test2, test3, encriptacion) VALUES ( :fechacreacion, :usuario, :descripcion, :chipid, :test1, :test2, :test3, :encriptacion)
$sql = "INSERT INTO chipids (id, fechacreacion, usuario, descripcion, chipid, test1, test2, test3, encriptacion) VALUES (NULL, NOW(), :usuario, :descripcion, :chipid, :test1, :test2, :test3, :encriptacion)";

echo "<br>";
echo "sql=  " . $sql;
echo "<br>";

$resultado = $base -> prepare($sql);
//$resultado ->execute(array(":fechacreacion" => $fechacreacion, ":usuario" => $usuario, ":descripcion" => $descripcion, ":chipId" => $chipid, ":test1" => $test1, ":test2" => $test2, ":test3" => $test3, ":encriptacion" => $encriptacion  ));   
$resultado ->execute(array(":usuario" => $usuario, ":descripcion" => $descripcion, ":chipid" => $chipid, ":test1" => $test1, ":test2" => $test2, ":test3" => $test3, ":encriptacion" => $encriptacion )); 

echo "ok";

?>