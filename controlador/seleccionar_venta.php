<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $estado_venta = $mysql->efectuarConsulta("SELECT estado_venta.idestado_venta, 
    estado_venta.nombre_estado
    FROM estado_venta
    WHERE estado_venta.idestado_venta < 3");
?>

    <option selected></option>
<?php //inicio del ciclo para ir colocando HTML 

while ($est = mysqli_fetch_array($estado_venta)) { ?>
    
    <option value="<?php echo $est['idestado_venta'] ?>" id="tipo_venta"><?php echo $est['nombre_estado'] ?></option>

<?php } //fin del ciclo

?>

<?php //desconecta la base de datos

    $mysql->desconectar();

?>