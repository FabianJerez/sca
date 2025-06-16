<?php

$chipid = $_POST ['chipid'];
$usuario = $_POST ['usuario'];
$test1 = $_POST ['test1'];
$test2 = $_POST ['test2'];
$test3 = $_POST ['test3'];


echo "CHIPID a ser modificado : " . $chipid;
echo "<br>";
echo "Usuario propietario: " . $usuario;
echo "<br>";
echo "SALIDA TEST1: " . $test1;
echo "<br>";
echo "SALIDA TEST2: " . $test2;
echo "<br>";
echo "SALIDA TEST3: " . $test3;


include("conexion.php");

echo "<br>";
echo "conexion";
echo "<br>";

$sql = "UPDATE chipids SET test1 = :test1, test2 = :test2, test3 = :test3 WHERE chipid = :chipid";
//$sql = "UPDATE  chipids SET (test1 = :test1, test2 = :test2, test3 = :test3) WHERE chipid = :chipid";
//sql= UPDATE chipids SET (test1 = :test1, test2 = :test2, test3 = :test3) WHERE chipid = :chipid
echo "<br>";
echo "sql=  " . $sql;
echo "<br>";

$resultado = $base -> prepare($sql);   
$resultado ->execute(array(":test1" => $test1, ":test2" => $test2, ":test3" => $test3, ":chipid" => $chipid )); 

echo "ok";

?>