<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    $idvendedores = $_POST['idvendedores'];

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $nombre = $mysql->efectuarConsulta("SELECT 
    vendedores.idvendedores, 
    vendedores.nombre,
    vendedores.CC,
    vendedores.contraseña
    FROM vendedores
    WHERE vendedores.idvendedores = '".$idvendedores."'");
?>

<p>nombre</p>
<?php //inicio del ciclo para ir colocando HTML 

while ($nom = mysqli_fetch_array($nombre)) { ?>
<input type="text" class="form-control" id="vendedor_nombre_edi" placeholder="Nombre del nuevo vendedor"
 aria-describedby="basic-addon3 basic-addon4" value="<?php echo$nom["nombre"]; ?>"><br>


 <p>documento</p>

<input type="text" class="form-control" id="vendedor_cc_edi" placeholder="Nombre del nuevo vendedor"
 aria-describedby="basic-addon3 basic-addon4" value="<?php echo$nom["CC"]; ?>"><br>



<p>contraseña</p>

<input type="password" class="form-control" id="vendedor_contraseña_edi" placeholder="Nombre del nuevo vendedor"
 aria-describedby="basic-addon3 basic-addon4" value="<?php echo$nom["contraseña"]; ?>"><br>

<?php } //fin del ciclo

?>
<div class="modal-footer bg-primary text-light align-content-center align-items-center justify-content-center text-center">
    <form class="d-flex" role="search">
        <button class="btn btn-primary" type="button" onclick="EditarVendedor(<?php echo $idvendedores;?>)"><i class="fa-solid fa-pen-to-square"></i> Editar</button>
    </form>
</div>

<?php //desconecta la base de datos

    $mysql->desconectar();

?>