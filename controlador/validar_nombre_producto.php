<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //toma los valores deseados
    $producto_nombre = $_POST['producto_nombre'];

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $existencia = $mysql->efectuarConsulta("SELECT producto.nombre_producto 
    FROM producto 
    WHERE producto.nombre_producto = '".$producto_nombre."'");

    if (mysqli_num_rows($existencia) > 0) { //el producto existe
        echo "existe";
    } else {
         echo "disponible";
    };

    //desconecta la base de datos

    $mysql->desconectar();
?>