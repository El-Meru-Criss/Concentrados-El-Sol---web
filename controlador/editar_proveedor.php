<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //toma los valores deseados
    $id_proveedor_edit = $_POST['id_proveedor_edit'];
    $Nombre_proveedor_editar = $_POST['Nombre_proveedor_editar'];
    $Proveedor_telefono_edit = $_POST['Proveedor_telefono_edit'];
    $Proveedor_banco_edit = $_POST['Proveedor_banco_edit'];

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $mysql->efectuarConsulta("UPDATE proveedor 
    SET proveedor.nombre='".$Nombre_proveedor_editar."',
    proveedor.telefono='".$Proveedor_telefono_edit."',
    proveedor.cuenta_bancaria='".$Proveedor_banco_edit."' 
    WHERE proveedor.idproveedor = '".$id_proveedor_edit."'");

    
?>

<?php

    //desconecta la base de datos

    $mysql->desconectar();
?>