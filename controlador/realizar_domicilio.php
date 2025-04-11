<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //toma los valores deseados
    $valor_total = $_POST['valor_total'];
    $producto = $_POST['producto'];
    $cantidad = $_POST['cantidad'];
    $vendedor = $_POST['vendedor'];
    $cliente = $_POST['cliente'];
    $unidad = $_POST['unidad'];
    $cantidad_pagada = $_POST['cantidad_pagada'];
    $seleccionar_venta = $_POST['seleccionar_venta'];

    //Inserta los datos en ventas

    $mysql->efectuarConsulta("INSERT INTO ventas 
    VALUES (NULL,'".$valor_total."','".$cliente."',
    '".$vendedor."','".$seleccionar_venta."'
    ,NOW(),'".$cantidad_pagada."')");
    
    //se saca el ID del ultimo pedido creado

    $venta_id = $mysql->efectuarConsulta("SELECT 
    ventas.idventas
    FROM ventas
    ORDER BY ventas.idventas DESC");

    $id = mysqli_fetch_array($venta_id);

    $domicilio_id = $mysql->efectuarConsulta("SELECT 
    estado_domicilio.idestado_domicilio
    FROM estado_domicilio
    ORDER BY estado_domicilio.idestado_domicilio ASC");

    $do = mysqli_fetch_array($domicilio_id);

    

    //Se cuentas cuantos productos se van a insertar

    $elementos = count($producto);

    //se inserta los productos

    for ($i=0; $i < $elementos ; $i++) {

        $mysql->efectuarConsulta("INSERT INTO inventario_has_ventas 
        VALUES ('".$producto[$i]."',
        '".$id[0]."',
        '".$cantidad[$i]."',
        NULL,
        '".$do[0]."',
        '".$unidad[$i]."')");

        $mysql->efectuarConsulta("UPDATE inventario 
        SET inventario.cantidad = inventario.cantidad - '".$cantidad[$i]."'
        WHERE inventario.idinventario = '"  .$producto[$i]."'");

        }

    //se inserta los datos de cartera

    if ($seleccionar_venta == 2)
    {
        $mysql->efectuarConsulta("INSERT INTO cartera 
        VALUES (NULL,'".$cliente."','".$id[0]."',
        '".$valor_total."', '".$cantidad_pagada."', NOW(),NOW(), 1)");
    }

    //desconecta la base de datos

    $mysql->desconectar();
?>
