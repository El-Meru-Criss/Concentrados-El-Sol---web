<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();
    $producto = $_POST['producto'];
    $idcasilla = $_POST['idcasilla'];

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $productos = $mysql->efectuarConsulta("SELECT proveedor_has_producto.producto_idproducto, 
    producto.nombre_producto,
    inventario.precio_publico,
    inventario.precio_bulto,
    inventario.idinventario,
    inventario.cantidad
    FROM proveedor_has_producto 
    INNER JOIN producto ON producto.idproducto = proveedor_has_producto.producto_idproducto
    INNER JOIN inventario ON inventario.proveedor_has_producto_producto_idproducto =  proveedor_has_producto.producto_idproducto
    WHERE inventario.cantidad > 0
    GROUP BY inventario.idinventario");

    
    
?>

<div class="input-group">
    <select class="form-select producto" aria-label="Default select example" onchange="validar_producto(<?php echo $idcasilla ?>), precio_renovar(<?php echo $idcasilla ?>), validar_duplicacion(<?php echo $idcasilla ?>) " id="producto<?php echo $idcasilla ?>" >
    <option selected></option>
<?php //inicio del ciclo para ir colocando HTML 

while ($prod = mysqli_fetch_array($productos)) { ?>
    
    <option data-precio="<?php echo $prod['precio_publico']?>" data-bulto="<?php echo $prod['precio_bulto']?>" data-cantidad="<?php echo $prod['cantidad']?>"  value="<?php echo $prod['idinventario'] ?>"><?php echo $prod['nombre_producto'] ?></option>
<?php } //fin del ciclo

?>
</select>
<select class="form-select unidad" aria-label="Default select example" onchange="precio_renovar(<?php echo $idcasilla ?>),validar_cantidad(<?php echo $idcasilla ?>), validar_duplicacion(<?php echo $idcasilla ?>) " id="unidad_medida<?php echo $idcasilla ?>" >
    <option selected=""> </option>
    <?php //inicio del ciclo para ir colocando HTML 

    $unidad_medida = $mysql->efectuarConsulta("SELECT unidad_medida.idunidad_medida,
    unidad_medida.nombre
    FROM unidad_medida");

while ($uni = mysqli_fetch_array($unidad_medida)) { ?>
    <option value="<?php echo $uni['idunidad_medida'] ?>"><?php echo $uni['nombre'] ?></option>
<?php } //fin del ciclo

?>
</select>
    <input type="number" onchange="validar_cantidad(<?php echo $idcasilla ?>)" class="form-control cantidad" id="cantidad<?php echo $idcasilla ?>" placeholder="cantidad" aria-describedby="basic-addon3 basic-addon4" min="0" max="0">
    <input type="number" onchange="valor_total()" class="form-control precio" id="precio<?php echo $idcasilla ?>" placeholder="Precio" aria-describedby="basic-addon3 basic-addon4"  disabled=""?>
</div>

<?php //desconecta la base de datos

    $mysql->desconectar();

?>