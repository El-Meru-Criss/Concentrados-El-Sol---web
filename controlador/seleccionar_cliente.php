<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $clientes = $mysql->efectuarConsulta("SELECT clientes.idclientes, 
    clientes.nombre
    FROM clientes");
?>

<div class="input-group">
<select class="form-select cliente"  id="seleccionar_cliente" aria-label="Default select example" onchange="cambiarnuevo(this)">
<option selected></option>
<?php //inicio del ciclo para ir colocando HTML 

while ($cli = mysqli_fetch_array($clientes)) { ?>
    
    <option value="<?php echo $cli['idclientes'] ?>" id="nombre_cliente"><?php echo $cli['nombre'] ?></option>

<?php } //fin del ciclo

?>
</select>

<?php //desconecta la base de datos

    $mysql->desconectar();

?>