<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //toma los valores deseados
    
    $id_producto = $_POST['id_producto'];
    $valor = $_POST['valor'];

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $mysql->efectuarConsulta("UPDATE producto 
    SET producto.peso = '".$valor."' 
    WHERE producto.idproducto = '".$id_producto."'");

    //desconecta la base de datos

    $mysql->desconectar();
?>