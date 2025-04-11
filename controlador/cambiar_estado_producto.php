<?php

function calcularDiferencia($fecha1, $fecha2) {
    // Crear objetos DateTime con las fechas
    $date1 = new DateTime($fecha1);
    $date2 = new DateTime($fecha2);

    // Obtener los timestamps de las fechas
    $timestamp1 = $date1->getTimestamp();
    $timestamp2 = $date2->getTimestamp();

    // Calcular la diferencia en segundos
    $diferencia = $timestamp2 - $timestamp1;

    // Convertir la diferencia en meses y días
    $meses = floor($diferencia / (30 * 24 * 60 * 60));
    $dias = floor(($diferencia - ($meses * 30 * 24 * 60 * 60)) / (24 * 60 * 60));

    return array('meses' => $meses, 'dias' => $dias);
}

// Ejemplo de uso

// $fechaFin = '2023-09-15';

// $resultado = calcularDiferencia($fechaActual, $fechaFin);

// echo $resultado['meses'] . ' meses y ' . $resultado['dias'] . ' días';

//llama a la base de datos con el modelo
require_once '../modelo/mysql.php';
$mysql = new MySQL();

$mysql->conectar();

//toma los valores deseados
$fechaActual = date('Y-m-d');

//realiza la consulta MySQL deseada, y la guarda en una variable

$producto = $mysql->efectuarConsulta("SELECT inventario.idinventario, 
inventario.fecha_entrada, 
inventario.fecha_caducidad
FROM inventario");

while ($Productos = mysqli_fetch_array($producto)) {
    $comparacion = calcularDiferencia($fechaActual, $Productos['fecha_caducidad']);
    
    if ($comparacion['meses'] < 0) {
        //caducado
        $mysql->efectuarConsulta("UPDATE inventario 
        SET inventario.estado_producto_idestado_producto = 2
        WHERE inventario.idinventario = '".$Productos['idinventario']."'");
    } else {
        # buen estado
        $mysql->efectuarConsulta("UPDATE inventario 
        SET inventario.estado_producto_idestado_producto = 1
        WHERE inventario.idinventario = '".$Productos['idinventario']."'");
    }

    

};

//desconecta la base de datos

$mysql->desconectar();



?>