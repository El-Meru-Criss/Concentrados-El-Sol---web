<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //toma los valores deseados
    $id_producto = $_POST['id_producto'];

    //realiza la consulta MySQL deseada

    $mysql->efectuarConsulta("UPDATE producto 
    SET producto.Estado_Producto= 1
    WHERE producto.idproducto = ".$id_producto."");

    //desconecta la base de datos

    $mysql->desconectar();
?>