<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $productos = $mysql->efectuarConsulta("SELECT producto.idproducto, 
    producto.nombre_producto,
    producto.peso 
    FROM producto
    WHERE producto.Estado_Producto = 0");
?>

<div class="m-2 align-content-center align-items-center justify-content-center text-center">
        
    <button onclick="tabla_inventario()" type="button" class="btn btn-warning"><i class="fa-solid fa-boxes-stacked"></i> Inventario</button>
    <button onclick="mostrar_productos()" type="button" class="btn btn-success"><i class="fa-solid fa-box-archive"></i> Habilitados</button>
</div>

<div class="row row-cols-2 row-cols-md-3 g-4">

    <?php //inicio del ciclo para ir colocando HTML 

    while ($pro = mysqli_fetch_array($productos)) { ?>
        
        <DIv class="col">
            <div class="card text-center h-100">
              <div class="card-header">
                <h5 class="card-title" style="margin-bottom: 0;">
                  <input onchange="Cambiar_nombre_producto(this,<?php echo $pro['idproducto'] ?>)" type="text" value="<?php echo $pro['nombre_producto'] ?>" class="form-control-plaintext text-center" id="Nombre_producto<?php echo $pro['idproducto'] ?>" placeholder="" aria-describedby="basic-addon3 basic-addon4">
                </h5>
              </div>
              <div class="card-body">

                <div class="input-group mb-1">
                  <span class="input-group-text" id="basic-addon1">Contenido:</span>
                  <input onchange="Cambiar_contenido(this,<?php echo $pro['idproducto'] ?>)" type="number" value="<?php echo $pro['peso'] ?>" class="form-control" id="Contenido_producto<?php echo $pro['idproducto'] ?>" placeholder="" aria-describedby="basic-addon3 basic-addon4">
                </div>
                <h6 class="card-title">Proveedores:</h6>
                <div style="max-height: 10rem; overflow: auto;">

                    <?php  

                    $proveedores = $mysql->efectuarConsulta("SELECT proveedor_has_producto.proveedor_idproveedor, 
                    proveedor.nombre 
                    FROM proveedor_has_producto 
                    INNER JOIN proveedor 
                    ON proveedor.idproveedor = proveedor_has_producto.proveedor_idproveedor
                    WHERE proveedor_has_producto.producto_idproducto = '".$pro['idproducto']."'
                    AND (proveedor_has_producto.estado = 1 OR proveedor_has_producto.estado IS NULL)");

                    $num_proveedores = 0;

                    while ($proveed = mysqli_fetch_array($proveedores)) {
                    
                    ?>

                  <div class="input-group p-2">
                    <span class="input-group-text col" id="basic-addon1"><?php echo $proveed['nombre'] ?>: </span>
                    <button onclick="desasociar_proveedor(<?php echo $pro['idproducto'] ?>,<?php echo $proveed['proveedor_idproveedor'] ?>)" type="button" class="btn btn-outline-danger col"><i class="fa-solid fa-circle-minus"></i> Quitar</button>
                  </div>

                  <?php 
                    //$num_proveedores += 1; 
                    } 
                  ?>
                  
                </div>
              </div>
              <div class="card-footer">
                <div class="input-group p-2">
                  <button onclick="habilitar_producto(<?php echo $pro['idproducto'] ?>,<?php echo $num_proveedores ?>)" type="button" class="btn btn-outline-success col"><i class="fa-solid fa-trash"></i> Habilitar</button>
                </div>
              </div>
            </div>
          </DIv>
        
    <?php } //fin del ciclo

    ?>
</div>

<?php //desconecta la base de datos

    $mysql->desconectar();

?>