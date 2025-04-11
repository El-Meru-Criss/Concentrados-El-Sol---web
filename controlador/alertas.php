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

//llama a la base de datos con el modelo
require_once '../modelo/mysql.php';
$mysql = new MySQL();

$mysql->conectar();

//toma los valores deseados
$fechaActual = date('Y-m-d');

//realiza la consulta MySQL deseada, y la guarda en una variable

$producto = $mysql->efectuarConsulta("SELECT inventario.idinventario, 
producto.nombre_producto, 
inventario.fecha_entrada, 
inventario.fecha_caducidad,
inventario.cantidad,
inventario.stock_minimo 
FROM inventario 
INNER JOIN proveedor_has_producto 
ON proveedor_has_producto.producto_idproducto = inventario.proveedor_has_producto_producto_idproducto 
INNER JOIN producto 
ON producto.idproducto = proveedor_has_producto.producto_idproducto
GROUP BY inventario.idinventario");

$Alertas = 0;

while ($Productos = mysqli_fetch_array($producto)) {
    $comparacion = calcularDiferencia($fechaActual, $Productos['fecha_caducidad']);
    
    if ($comparacion['meses'] <= 0 && $Productos['fecha_caducidad'] != '') {
        $Alertas += 1;
    };

    if ($Productos['cantidad'] <= $Productos['stock_minimo'] && $Productos['stock_minimo'] != '') {
        $Alertas += 1;
    };

};

echo $Alertas;

//desconecta la base de datos

$mysql->desconectar();



?>