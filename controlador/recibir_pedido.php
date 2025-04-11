<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //toma los valores deseados
    $id_pedido = $_POST['id_pedido'];

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $productos = $mysql->efectuarConsulta("SELECT proveedor_has_producto_has_pedidos_proveedor.proveedor_has_producto_producto_idproducto,
    proveedor_has_producto_has_pedidos_proveedor.cantidad
    FROM proveedor_has_producto_has_pedidos_proveedor
    WHERE proveedor_has_producto_has_pedidos_proveedor.pedidos_proveedor_idpedidos_proveedor = '".$id_pedido."'");

    while ($prod = mysqli_fetch_array($productos)) {
        
        $existencia = $mysql->efectuarConsulta("SELECT inventario.idinventario, 
        inventario.cantidad,
        inventario.proveedor_has_producto_producto_idproducto 
        FROM inventario 
        WHERE inventario.proveedor_has_producto_producto_idproducto = '".$prod['proveedor_has_producto_producto_idproducto']."'");

        $peso_producto = $mysql->efectuarConsulta("SELECT producto.peso 
        FROM producto 
        WHERE producto.idproducto = '".$prod['proveedor_has_producto_producto_idproducto']."'");

        $peso = mysqli_fetch_array($peso_producto);


        if (mysqli_num_rows($existencia) > 0) {

            $exis = mysqli_fetch_array($existencia);
            $total = $exis['cantidad'] + ($prod['cantidad'] * $peso['peso']);

            $mysql->efectuarConsulta("UPDATE inventario 
            SET inventario.cantidad='".$total."',
            inventario.fecha_entrada=CURDATE() 
            WHERE inventario.proveedor_has_producto_producto_idproducto = '".$prod['proveedor_has_producto_producto_idproducto']."'");

        } else {

            $total = $prod['cantidad'] * $peso['peso'];

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

        }

        $mysql->efectuarConsulta("UPDATE pedidos_proveedor 
        SET pedidos_proveedor.estado_pedido='1' 
        WHERE pedidos_proveedor.idpedidos_proveedor = '".$id_pedido."'");

    }
    //desconecta la base de datos

    $mysql->desconectar();
?>