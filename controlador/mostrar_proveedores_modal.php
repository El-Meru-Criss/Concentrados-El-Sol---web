<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $proveedores = $mysql->efectuarConsulta("SELECT 
    proveedor.idproveedor, 
    proveedor.nombre 
    FROM proveedor");
?>

<?php //inicio del ciclo para ir colocando HTML 

while ($prov = mysqli_fetch_array($proveedores)) { ?>
    
    <tr>
        <th><?php echo $prov['nombre']; ?></th>
        <th>
            <button onclick="eliminar_proveedor(<?php echo $prov['idproveedor']; ?>)" type="button" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
            <button data-bs-target="#exampleModalToggle3" data-bs-toggle="modal" onclick="info_proveedor(<?php echo $prov['idproveedor']; ?>)" type="button" class="btn btn-outline-info btn-sm"><i class="fa-solid fa-pen"></i></button>
        </th>
    </tr>

<?php } //fin del ciclo

?>

<?php //desconecta la base de datos

    $mysql->desconectar();

?>