<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //toma los valores deseados
    
    $id_inventario = $_POST['id_inventario'];
    $StockMinimo = $_POST['StockMinimo'];

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $mysql->efectuarConsulta("UPDATE inventario 
    SET inventario.stock_minimo = '".$StockMinimo."' 
    WHERE inventario.idinventario = '".$id_inventario."'");

    //desconecta la base de datos

    $mysql->desconectar();
?>