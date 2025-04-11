<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //toma los valores deseados
    $id_pedido = $_POST['id_pedido'];
    $Productos = $_POST['Productos'];
    $Cantidad = $_POST['Cantidad'];

    //Cuenta los productos se van a insertar

    $elemento = 0;

    //Cuenta todos los productos pedidos y todos los productos que llegaron

    $pedidos = 0;
    $entregados = 0;

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $productos = $mysql->efectuarConsulta("SELECT proveedor_has_producto_has_pedidos_proveedor.proveedor_has_producto_producto_idproducto,
    proveedor_has_producto_has_pedidos_proveedor.recibidos,
    proveedor_has_producto_has_pedidos_proveedor.cantidad
    FROM proveedor_has_producto_has_pedidos_proveedor
    WHERE proveedor_has_producto_has_pedidos_proveedor.pedidos_proveedor_idpedidos_proveedor = '".$id_pedido."'");

    while ($prod = mysqli_fetch_array($productos)) {

        $total_recibido = 0;
        
        $existencia = $mysql->efectuarConsulta("SELECT inventario.idinventario, 
        inventario.cantidad,
        inventario.proveedor_has_producto_producto_idproducto 
        FROM inventario 
        WHERE inventario.proveedor_has_producto_producto_idproducto = '".$prod['proveedor_has_producto_producto_idproducto']."'");

        $peso_producto = $mysql->efectuarConsulta("SELECT producto.peso 
        FROM producto 
        WHERE producto.idproducto = '".$prod['proveedor_has_producto_producto_idproducto']."'");

        $peso = mysqli_fetch_array($peso_producto);


        if (mysqli_num_rows($existencia) > 0 
        && $prod['proveedor_has_producto_producto_idproducto'] == $Productos[$elemento]) {

            $exis = mysqli_fetch_array($existencia);
            $total = $exis['cantidad'] + ($Cantidad[$elemento] * $peso['peso']);

            $mysql->efectuarConsulta("UPDATE inventario 
            SET inventario.cantidad='".$total."',
            inventario.fecha_entrada=CURDATE() 
            WHERE inventario.proveedor_has_producto_producto_idproducto = '".$prod['proveedor_has_producto_producto_idproducto']."'");

            $total_recibido = $prod['recibidos'] + $Cantidad[$elemento];
            $entregados += $Cantidad[$elemento];

            $mysql->efectuarConsulta("UPDATE proveedor_has_producto_has_pedidos_proveedor 
            SET proveedor_has_producto_has_pedidos_proveedor.recibidos = '".$total_recibido."' 
            WHERE proveedor_has_producto_has_pedidos_proveedor.pedidos_proveedor_idpedidos_proveedor = '".$id_pedido."' 
            AND proveedor_has_producto_has_pedidos_proveedor.proveedor_has_producto_producto_idproducto = '".$prod['proveedor_has_producto_producto_idproducto']."'");

            $elementos_contador = count($Cantidad) - 1;
            if ($elemento != $elementos_contador) {
                $elemento += 1;
            }
            

        } else {

            if ($prod['proveedor_has_producto_producto_idproducto'] == $Productos[$elemento]) {
                $total = $Cantidad[$elemento] * $peso['peso'];

                $mysql->efectuarConsulta("INSERT INTO inventario
                (inventario.idinventario, 
                inventario.cantidad, 
                inventario.fecha_entrada, 
                inventario.proveedor_has_producto_producto_idproducto, 
                inventario.estado_producto_idestado_producto) 
                VALUES 
                (NULL,
                '".$total."',
                CURDATE(),
                '".$prod['proveedor_has_producto_producto_idproducto']."',
                '1')");

                $total_recibido = $prod['recibidos'] + $Cantidad[$elemento];

                $entregados += $Cantidad[$elemento];

                $mysql->efectuarConsulta("UPDATE proveedor_has_producto_has_pedidos_proveedor 
                SET proveedor_has_producto_has_pedidos_proveedor.recibidos = '".$total_recibido."' 
                WHERE proveedor_has_producto_has_pedidos_proveedor.pedidos_proveedor_idpedidos_proveedor = '".$id_pedido."' 
                AND proveedor_has_producto_has_pedidos_proveedor.proveedor_has_producto_producto_idproducto = '".$prod['proveedor_has_producto_producto_idproducto']."'");

                $elementos_contador = count($Cantidad) - 1;
                if ($elemento != $elementos_contador) {
                    $elemento += 1;
                }
            }

        }

        $pedidos += $prod['cantidad'];
        $entregados += $prod['recibidos'];
    }

    if ($pedidos == $entregados) {
        $mysql->efectuarConsulta("UPDATE pedidos_proveedor 
        SET pedidos_proveedor.estado_pedido='1' 
        WHERE pedidos_proveedor.idpedidos_proveedor = '".$id_pedido."'");

        echo "refrescar";
    }
    //desconecta la base de datos

    $mysql->desconectar();
?>