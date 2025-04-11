<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //toma los valores deseados
    $Nombre_proveedor = $_POST['Nombre_proveedor'];
    $Proveedor_telefono = $_POST['Proveedor_telefono'];
    $Proveedor_banco = $_POST['Proveedor_banco'];

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $mysql->efectuarConsulta("INSERT INTO proveedor 
    VALUES (NULL, 
    '".$Nombre_proveedor."', 
    '".$Proveedor_telefono."', 
    '".$Proveedor_banco."')");

    //desconecta la base de datos

    $mysql->desconectar();
?>