<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //toma los valores deseados
    
    $id_inventario = $_POST['id_inventario'];
    $F_vencimiento = $_POST['F_vencimiento'];

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $mysql->efectuarConsulta("UPDATE inventario 
    SET inventario.fecha_caducidad = '".$F_vencimiento."' 
    WHERE inventario.idinventario = '".$id_inventario."'");

    //desconecta la base de datos

    $mysql->desconectar();
?>