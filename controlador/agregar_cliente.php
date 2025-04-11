<?php //llama a la base de datos con el modelo

    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //toma los valores deseados
    $cliente_nombre = $_POST['cliente_nombre'];
    $cliente_telefono = $_POST['cliente_telefono'];
    $cliente_direccion = $_POST['cliente_direccion'];
    $email = $_POST['email'];
    $documento = $_POST['documento'];

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $mysql->efectuarConsulta("INSERT INTO clientes 
    VALUES (NULL,
    '".$cliente_nombre."',
    '".$cliente_telefono."',
    '".$cliente_direccion."',
    '".$email."',
    '".$documento."')");

    //desconecta la base de datos

    $mysql->desconectar();
?>