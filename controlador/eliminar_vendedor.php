<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //toma los valores deseados
    $idvendedores = $_POST['idvendedores'];

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $mysql->efectuarConsulta("DELETE FROM vendedores 
    WHERE vendedores.idvendedores = ".$idvendedores."");

    //desconecta la base de datos

    $mysql->desconectar();
?>