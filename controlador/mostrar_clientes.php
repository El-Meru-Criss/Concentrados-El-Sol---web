<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $clientes = $mysql->efectuarConsulta("SELECT 
    clientes.idclientes, 
    clientes.nombre,
    clientes.telefono,
    clientes.direccion,
    clientes.correo,
    clientes.documento
    FROM clientes");
?>

<?php //inicio del ciclo para ir colocando HTML 

while ($cli = mysqli_fetch_array($clientes)) { ?>
    
    <tr>
        <th><?php echo $cli['nombre']; ?></th>
        <th><?php echo $cli['telefono']; ?></th>
        <th><?php echo $cli['direccion']; ?></th>
        <th><?php echo $cli['correo']; ?></th>
        <th><?php echo $cli['documento']; ?></th>
        <th>
            <button onclick="eliminar_cliente(<?php echo $cli['idclientes']; ?>)" type="button" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
            <button onclick="mostrar_datos_cliente(<?php echo $cli['idclientes']; ?>)" type="button" class="btn btn-outline-info btn-sm" data-bs-target="#editar_cliente" data-bs-toggle="modal"><i class="fa-solid fa-pen"></i></button>
        </th>
    </tr>

<?php } //fin del ciclo

?>

<?php //desconecta la base de datos

    $mysql->desconectar();

?>