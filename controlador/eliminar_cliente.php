<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //toma los valores deseados
    $idclientes = $_POST['idclientes'];

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $mysql->efectuarConsulta("DELETE FROM clientes 
    WHERE clientes.idclientes = ".$idclientes."");

    //desconecta la base de datos

    $mysql->desconectar();
?>