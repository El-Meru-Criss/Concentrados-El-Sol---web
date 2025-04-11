<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //toma los valores deseados
    $seleccionar_producto = $_POST['seleccionar_producto'];
    $proveedores_crear_producto = $_POST['proveedores_crear_producto'];

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $existencia = $mysql->efectuarConsulta("SELECT proveedor_has_producto.proveedor_idproveedor, 
    proveedor_has_producto.producto_idproducto 
    FROM proveedor_has_producto 
    WHERE proveedor_has_producto.proveedor_idproveedor = '".$proveedores_crear_producto."' 
    AND proveedor_has_producto.producto_idproducto = '".$seleccionar_producto."'
    AND proveedor_has_producto.estado = 1");

    if (mysqli_num_rows($existencia) > 0) { //el producto existe
        echo "existe";
    } else {
         echo "disponible";
    };

    //desconecta la base de datos

    $mysql->desconectar();
?>