<?php //llama a la base de datos con el modelo

    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //toma los valores deseados
    $vendedor_nombre = $_POST['vendedor_nombre'];
    $vendedor_documento = $_POST['vendedor_documento'];
    $vendedor_contraseña = $_POST['vendedor_contraseña'];

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $mysql->efectuarConsulta("INSERT INTO vendedores 
    VALUES (NULL,
    '".$vendedor_nombre."', 
    '".$vendedor_documento."', 
    '".$vendedor_contraseña."', 
    0)");

    //desconecta la base de datos

    $mysql->desconectar();
?>