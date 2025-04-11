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
<option value=""></option>
<?php //inicio del ciclo para ir colocando HTML 

while ($prov = mysqli_fetch_array($proveedores)) { ?>
    
    <option value="<?php echo $prov['idproveedor'] ?>"><?php echo $prov['nombre'] ?></option>

<?php } //fin del ciclo

?>

<option onclick="mostrar_provedores_producto()">actualizar</option>

<?php //desconecta la base de datos

    $mysql->desconectar();

?>