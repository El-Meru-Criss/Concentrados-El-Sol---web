<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //toma los valores deseados
    $idvendedores = $_POST['idvendedores'];
    $vendedor_nombre = $_POST['vendedor_nombre'];
    $vendedor_cc = $_POST['vendedor_cc'];
    $vendedor_contraseña = $_POST['vendedor_contraseña'];

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $mysql->efectuarConsulta("UPDATE vendedores
    SET vendedores.nombre = '".$vendedor_nombre."',
    vendedores.CC = '".$vendedor_cc."',
    vendedores.contraseña = '".$vendedor_contraseña."'
    WHERE vendedores.idvendedores = '".$idvendedores."'");

    //desconecta la base de datos

    $mysql->desconectar();
?>