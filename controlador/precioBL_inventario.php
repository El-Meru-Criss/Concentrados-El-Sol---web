<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //toma los valores deseados
    
    $id_inventario = $_POST['id_inventario'];
    $precio_bulto = $_POST['precio_bulto'];

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $mysql->efectuarConsulta("UPDATE inventario 
    SET inventario.precio_bulto = '".$precio_bulto."' 
    WHERE inventario.idinventario = '".$id_inventario."'");

    //desconecta la base de datos

    $mysql->desconectar();
?>