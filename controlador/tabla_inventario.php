<?php 
  //llamo el modelo
  require '../modelo/usuarios.php';
  //instancio la clase
  $user = new Usuario();

  //inicio sesion
  session_start();
  
  //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    $usuario = $_SESSION['usuario'];

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $productos = $mysql->efectuarConsulta("SELECT inventario.idinventario, 
    producto.nombre_producto, 
    producto.idproducto,
    inventario.cantidad, 
    inventario.precio_publico, 
    inventario.precio_bulto, 
    inventario.fecha_entrada, 
    inventario.fecha_caducidad,
    inventario.stock_minimo 
    FROM inventario 
    INNER JOIN proveedor_has_producto ON proveedor_has_producto.producto_idproducto = inventario.proveedor_has_producto_producto_idproducto
    INNER JOIN producto ON proveedor_has_producto.producto_idproducto = producto.idproducto
    WHERE producto.Estado_Producto IS NULL 
    OR producto.Estado_Producto = 1
    GROUP BY inventario.idinventario");
?>

<div class="table-responsive">



        <table class="table tabla-deudores">
            <thead class="">
              <tr>
                <th scope="col">Historial</th>
                <th scope="col">Producto</th>
                <th scope="col">Kg</th>
                <th scope="col">Precio Kg</th>
                <th scope="col">Precio Bulto</th>
                <th scope="col">Ingreso</th>
                <th scope="col">Vencimiento</th>
                <th scope="col">Stock Minimo (Kg)</th>
              </tr>
            </thead>
            <tbody>
              
              
<?php //inicio del ciclo para ir colocando HTML 



while ($prod = mysqli_fetch_array($productos)) { ?>
    
            <tr>
                <td><button onclick="historial_ingreso(<?php echo $prod['idproducto'] ?>)" <?php if ($usuario->getRol() != 1) {?> disabled<?php } ?> type="button" class="btn btn-outline-primary"><i class="fa-solid fa-book"></i></button></td>
                <td><?php echo $prod['nombre_producto'] ?></td>
                <td><?php echo $prod['cantidad'] ?></td>
                <td>
                  
                <input onchange="precioKL_inventario(<?php echo $prod['idinventario'] ?>)" <?php if ($usuario->getRol() != 1) {?> readonly<?php } ?>  value="<?php echo $prod['precio_publico'] ?>" class="form-control <?php if ($usuario->getRol() != 1) {?> form-control-plaintext<?php } ?> form-control-sm" id="precio_kl<?php echo $prod['idinventario'] ?>" type="number" style="width: 10rem;">
        
                </td>
                <td>
                <input onchange="precioBL_inventario(<?php echo $prod['idinventario'] ?>)" <?php if ($usuario->getRol() != 1) {?> readonly<?php } ?>  value="<?php echo $prod['precio_bulto'] ?>" type="number" class="form-control <?php if ($usuario->getRol() != 1) {?> form-control-plaintext<?php } ?> form-control-sm" id="precio_bulto<?php echo $prod['idinventario'] ?>" style="width: 10rem;">
                  
                </td>
                <td>
                <input readonly value="<?php echo $prod['fecha_entrada'] ?>" type="date" class="form-control-plaintext form-control-sm" id="F_entrada">
              
              </td>
                <td>
                  <input onchange="F_vencimiento(<?php echo $prod['idinventario'] ?>)"  <?php if ($usuario->getRol() != 1) {?> readonly<?php } ?> value="<?php echo $prod['fecha_caducidad'] ?>" type="date" class="form-control-plaintext form-control-sm" id="F_vencimiento<?php echo $prod['idinventario'] ?>">
                </td>
                <td>
                  
                <input onchange="StockMinimo(<?php echo $prod['idinventario'] ?>)" <?php if ($usuario->getRol() != 1) {?> readonly<?php } ?>  value="<?php echo $prod['stock_minimo'] ?>" class="form-control <?php if ($usuario->getRol() != 1) {?> form-control-plaintext<?php } ?> form-control-sm" id="StockMinimo<?php echo $prod['idinventario'] ?>" type="number" style="width: 10rem;">
        
                </td>
            </tr>

<?php } //fin del ciclo

?>

            </tbody>
          </table>          
      </div>

<?php //desconecta la base de datos

    $mysql->desconectar();

?>