<?php

$chipid = $_POST ['chipid'];
$temperatura = $_POST ['temperatura'];
$humedad = $_POST ['humedad'];

$test1 = $_POST ['test1'];
$test2 = $_POST ['test2'];
$test3 = $_POST ['test3'];

$frizer = $_POST ['frizer'];
$gas = $_POST ['gas'];
$refrigerador = $_POST ['refrigerador'];


// echo "Dato recibido del chip id del modulo: "  . $chipid;
// echo "<br>";
// echo "Dato recibido temperatura: " . $temperatura;
// echo "<br>";
// echo "Dato recibido humedad: " . $humedad;
// echo "<br>";
// echo "Dato recibido test1: " . $test1;
// echo "<br>";
// echo "Dato recibido test2: " . $test2;
// echo "<br>";
// echo "Dato recibido test3: " . $test3;
// echo "<br>";
// echo "Dato recibido frizer: " . $frizer;
// echo "<br>";
// echo "Dato recibido gas: " . $gas;
// echo "<br>";
// echo "Dato recibido refrigerador: " . $refrigerador;


include("conexion.php");

// echo "<br>";
// echo "conexion";
// echo "<br>";


//$sql = "INSERT INTO datos_recibe(chipid, fecha, temperatura, humedad, test1, test2, test3, frizer, gas, refrigerador) VALUES (:chipId,:fecha,:temperatura,:humedad,:test1,:test2,:test3,:frizer,:gas,:refrigerador)";

$sql = "INSERT INTO datos_recibe(chipid, fecha, temperatura, humedad, test1, test2, test3, frizer, gas, refrigerador) VALUES (:chipId,NOW(),:temperatura,:humedad,:test1,:test2,:test3,:frizer,:gas,:refrigerador)";

// echo "<br>";
// echo "sql=  " . $sql;
// echo "<br>";

$resultado = $base -> prepare($sql);
$ctstamp = date('Y-m-d H:i:s'); // Formato: 2023-10-27 15:30:00

//$resultado ->execute(array(":chipId" => $chipid , ":fecha" => $ctstamp, ":temperatura" => $temperatura, ":humedad" => $humedad, ":test1" => $test1, ":test2" => $test2, ":test3" => $test3, ":frizer" => $frizer, ":gas" => $gas, ":refrigerador" => $refrigerador));   

$resultado ->execute(array(":chipId" => $chipid , ":temperatura" => $temperatura, ":humedad" => $humedad, ":test1" => $test1, ":test2" => $test2, ":test3" => $test3, ":frizer" => $frizer, ":gas" => $gas, ":refrigerador" => $refrigerador));



echo "ok";

$sql = "SELECT * FROM chipids WHERE chipId = :chipId";
$resultado = $base ->prepare($sql);
$resultado ->execute(array(":chipId" => $chipid));

foreach($resultado as $fila):
    echo  "TEST1=" . $fila['test1'];  
    echo  "TEST2=" . $fila['test2'];
    echo  "TEST3=" . $fila['test3'];
endforeach;  

echo "ok";

?>