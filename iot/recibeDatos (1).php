<?php

$chipid = $_POST ['chipid'];
$temperatura = $_POST ['temperatura'];

echo "Dato recibido del chip id del modulo: "  . $chipid;
echo "<br>";
echo "Dato recibido temperatura: " . $temperatura;

include("conexion.php");

echo "<br>";
echo "conexion";
echo "<br>";


$sql = "INSERT INTO datos_recibidos(chipId, fecha, temperatura) VALUES (:chipId,:fecha,:temperatura)";

echo "<br>";
echo "sql=  " . $sql;
echo "<br>";

$resultado = $base -> prepare($sql);
$ctstamp = date('Y-m-d H:i:s'); // Formato: 2023-10-27 15:30:00

echo "<br>";
echo "fecha " . $ctstamp;
echo "<br>";

$resultado ->execute(array(":chipId" => $chipid , ":fecha" => $ctstamp, ":temperatura" => $temperatura));   //nofunciona 

//$resultado ->execute(array(":chipId" => "111" , ":fecha" => "111", ":temperatura" => "111")); //funciona asi

//$resultado ->execute(array(":chipId" => "44" , ":fecha" => $ctstamp, ":temperatura" => $temperatura)); 

echo "ok";



?>

