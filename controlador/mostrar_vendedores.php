<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $vendedores = $mysql->efectuarConsulta("SELECT 
    vendedores.idvendedores, 
    vendedores.nombre 
    FROM vendedores");
?>

<?php //inicio del ciclo para ir colocando HTML 

while ($ven = mysqli_fetch_array($vendedores)) { ?>
    
    <tr>
        <th><?php echo $ven['nombre']; ?></th>
        <th>
            <button onclick="eliminar_vendedor(<?php echo $ven['idvendedores']; ?>)" type="button" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
            <button onclick="mostrar_datos_vendedor(<?php echo $ven['idvendedores']; ?>)" type="button" class="btn btn-outline-info btn-sm" data-bs-target="#editar_vendedor" data-bs-toggle="modal"><i class="fa-solid fa-pen"></i></button>
        </th>
    </tr>

<?php } //fin del ciclo

?>

<?php //desconecta la base de datos

    $mysql->desconectar();

?>