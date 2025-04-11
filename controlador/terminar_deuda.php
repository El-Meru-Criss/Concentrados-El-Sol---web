<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

   //toma los valores deseados
   $id_venta = $_POST['idventas'];

   //realiza la consulta MySQL deseada, y la guarda en una variable

   $mysql->efectuarConsulta("UPDATE ventas 
   SET ventas.estado_venta_idestado_venta = 3 
   WHERE ventas.idventas='".$id_venta."'");
   
   echo $id_venta;
   
    //desconecta la base de datos

    $mysql->desconectar();
?>