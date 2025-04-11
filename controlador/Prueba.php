<?php
// Llama a la base de datos con el modelo
require_once '../modelo/mysql.php';
$mysql = new MySQL();
$mysql->conectar();

// Realiza la consulta MySQL deseada y la guarda en una variable
$consulta = "INSERT INTO vendedores VALUES ('','lol','1','lol','0')";

$mysql->efectuarConsulta($consulta);

$mysql->desconectar();

?>