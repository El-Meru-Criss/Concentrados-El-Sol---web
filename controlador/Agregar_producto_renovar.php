<?php
// Llama a la base de datos con el modelo
require_once '../modelo/mysql.php';
$mysql = new MySQL();

try {
    $mysql->conectar();

    // Toma los valores deseados
    $provedores_renovar = $_POST['provedores_renovar'];
    $idcasilla = $_POST['idcasilla'];

    // Realiza la consulta MySQL deseada, y la guarda en una variable
    $productos = $mysql->efectuarConsulta("SELECT u318418490_sol.proveedor_has_producto.producto_idproducto, 
    u318418490_sol.producto.nombre_producto,
    u318418490_sol.proveedor_has_producto.precio
    FROM u318418490_sol.proveedor_has_producto 
    INNER JOIN u318418490_sol.producto 
    ON u318418490_sol.producto.idproducto = u318418490_sol.proveedor_has_producto.producto_idproducto 
    WHERE u318418490_sol.proveedor_has_producto.proveedor_idproveedor = " . intval($provedores_renovar) . "
    AND u318418490_sol.proveedor_has_producto.estado = 1");

    if (!$productos) {
        throw new Exception("Error en la consulta: " . mysqli_error($mysql->conexion));
    }
?>

<div class="input-group">
    <select onchange="precio_renovar(<?php echo $idcasilla ?>)" id="producto<?php echo $idcasilla ?>" class="form-select productos_renovar" aria-label="Default select example">
        <option selected=""> </option>
        <?php // Inicio del ciclo para ir colocando HTML 
        while ($prod = mysqli_fetch_array($productos)) { ?>
            <option value="<?php echo $prod['producto_idproducto'] ?>"><?php echo $prod['nombre_producto'] ?></option>            
        <?php } // Fin del ciclo
        ?>
    </select>
    <input type="number" onchange="validar_cantidad(<?php echo $idcasilla ?>)" class="form-control cantidad_renovar" id="cantidad<?php echo $idcasilla ?>" placeholder="cantidad" aria-describedby="basic-addon3 basic-addon4">
    <input type="number" onchange="cambiar_precio_compra(<?php echo $idcasilla ?>)" class="form-control precio_renovar" id="precio<?php echo $idcasilla ?>" placeholder="Precio" aria-describedby="basic-addon3 basic-addon4">
</div>

<?php
    // Libera el resultado de la consulta y desconecta la base de datos
    $mysql->liberarResultado();
    $mysql->desconectar();
} catch (Exception $e) {
    // Manejo de errores
    error_log($e->getMessage());
    echo "Error al procesar la solicitud, por favor intenta más tarde.";
}
?>
