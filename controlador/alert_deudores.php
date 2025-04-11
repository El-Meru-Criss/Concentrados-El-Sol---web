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
    $dias = floor(($diferencia) / (24 * 60 * 60));

    return array('meses' => $meses, 'dias' => $dias);
}

//llama a la base de datos con el modelo
require_once '../modelo/mysql.php';
$mysql = new MySQL();

$mysql->conectar();

//toma los valores deseados
$fechaActual = date('Y-m-d');

//realiza la consulta MySQL deseada, y la guarda en una variable

$producto = $mysql->efectuarConsulta("SELECT ventas.fecha_venta,
ventas.idventas
FROM inventario_has_ventas
INNER JOIN unidad_medida ON inventario_has_ventas.unidad_medida_idunidad_medida = unidad_medida.idunidad_medida
INNER JOIN inventario ON inventario_has_ventas.inventario_idinventario = inventario.idinventario
INNER JOIN ventas ON inventario_has_ventas.ventas_idventas = ventas.idventas
INNER JOIN clientes ON ventas.clientes_idclientes = clientes.idclientes
INNER JOIN proveedor_has_producto ON inventario.proveedor_has_producto_producto_idproducto = proveedor_has_producto.producto_idproducto
INNER JOIN producto ON proveedor_has_producto.producto_idproducto = producto.idproducto
WHERE ventas.estado_venta_idestado_venta=2 GROUP BY ventas.idventas");

$Alertas = 0;

while ($Productos = mysqli_fetch_array($producto)) {
    $comparacion = calcularDiferencia($fechaActual, $Productos['fecha_venta']);

    
    
    if ($comparacion['dias'] <= -15) {
        $Alertas += 1;
    };

};

echo $Alertas;

//desconecta la base de datos

$mysql->desconectar();



?>