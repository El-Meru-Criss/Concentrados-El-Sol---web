<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //toma los valores deseados
    $producto_id = $_POST['producto_id'];
    $proveedor = $_POST['proveedor'];

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $consultar_precio = $mysql->efectuarConsulta("SELECT proveedor_has_producto.precio 
    FROM proveedor_has_producto 
    WHERE proveedor_has_producto.producto_idproducto = '".$producto_id."' 
    AND proveedor_has_producto.proveedor_idproveedor = '".$proveedor."'");

    $precio = mysqli_fetch_array($consultar_precio);

    echo $precio[0];

    
?>

<?php

    //desconecta la base de datos

    $mysql->desconectar();
?>