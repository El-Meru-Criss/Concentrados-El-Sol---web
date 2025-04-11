<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    $idcliente = $_POST['idclientes'];

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $cliente = $mysql->efectuarConsulta("SELECT 
    clientes.idclientes, 
    clientes.nombre,
    clientes.telefono,
    clientes.direccion,
    clientes.correo,
    clientes.documento
    FROM clientes
    WHERE clientes.idclientes = '".$idcliente."'");
?>

<p>nombre</p>
<?php //inicio del ciclo para ir colocando HTML 

while ($cli = mysqli_fetch_array($cliente)) { ?>
<input type="text" class="form-control" id="cliente_nombre_edi" placeholder="Nombre del cliente"
 aria-describedby="basic-addon3 basic-addon4" value="<?php echo$cli["nombre"]; ?>"><br>

<p class="lh-1">telefeno del cliente</p>



<input type="text" class="form-control" id="cliente_telefono_edi" 
placeholder="telefono del cliente (opcional)" aria-describedby="basic-addon3 basic-addon4"
value="<?php echo$cli["telefono"];?>"><br>

<p class="lh-1">direccion del cliente</p>

<input type="text" class="form-control" id="cliente_direccion_edi" 
placeholder="direccion del cliente (opcional)" aria-describedby="basic-addon3 basic-addon4"
value="<?php echo$cli["direccion"];?>"><br>

<p class="lh-1">correo electronico</p>

<input type="email" class="form-control" id="email_edi" 
placeholder="correo del cliente (opcional)" aria-describedby="basic-addon3 basic-addon4"
value="<?php echo$cli["correo"];?>"><br>

<p class="lh-1">numero de documento</p>

<input type="number" class="form-control" id="documento_edi" 
placeholder="numero de documento del cliente (opcional)" aria-describedby="basic-addon3 basic-addon4"
value="<?php echo$cli["documento"];?>"><br>

<?php } //fin del ciclo

?>
<div class="modal-footer bg-primary text-light align-content-center align-items-center justify-content-center text-center">
    <form class="d-flex" role="search">
        <button class="btn btn-primary" type="button" onclick="EditarCliente(<?php echo $idcliente;?>)"><i class="fa-solid fa-pen-to-square"></i> Editar</button>
    </form>
</div>

<?php //desconecta la base de datos

    $mysql->desconectar();

?>