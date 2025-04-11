<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //toma los valores deseados
    $id_producto = $_POST['id_producto'];

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $pedidos = $mysql->efectuarConsulta("SELECT pedidos_proveedor.idpedidos_proveedor, 
    proveedor.nombre, 
    pedidos_proveedor.fecha_pedido, 
    pedidos_proveedor.estado_pedido  
    FROM proveedor_has_producto_has_pedidos_proveedor 
    
    INNER JOIN proveedor_has_producto 
    ON proveedor_has_producto_has_pedidos_proveedor.proveedor_has_producto_proveedor_idproveedor = proveedor_has_producto.proveedor_idproveedor AND proveedor_has_producto_has_pedidos_proveedor.proveedor_has_producto_producto_idproducto = proveedor_has_producto.producto_idproducto
    
    INNER JOIN proveedor 
    ON proveedor.idproveedor = proveedor_has_producto.proveedor_idproveedor
    
    INNER JOIN pedidos_proveedor 
    ON pedidos_proveedor.idpedidos_proveedor = proveedor_has_producto_has_pedidos_proveedor.pedidos_proveedor_idpedidos_proveedor
    WHERE proveedor_has_producto_has_pedidos_proveedor.recibidos > 0 
    AND proveedor_has_producto_has_pedidos_proveedor.proveedor_has_producto_producto_idproducto = '".$id_producto."'
    ORDER BY pedidos_proveedor.idpedidos_proveedor DESC");
?>

<div class="mt-2 align-content-center align-items-center justify-content-center text-center">
        
    <button onclick="tabla_inventario()" type="button" class="btn btn-warning"><i class="fa-solid fa-boxes-stacked"></i> Inventario</button>
     
</div>

<div class="accordion p-2" id="accordionExample">

    <?php //inicio del ciclo para ir colocando HTML 

    while ($ped = mysqli_fetch_array($pedidos)) { ?>
        
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button onclick="productos_pedidos(<?php echo $ped['idpedidos_proveedor'] ?>)" class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $ped['idpedidos_proveedor'] ?>" aria-expanded="true" aria-controls="collapseOne">
                <?php echo $ped['nombre'] ?> - <?php echo $ped['fecha_pedido'] ?>
                </button>
            </h2>
            <div id="collapse<?php echo $ped['idpedidos_proveedor'] ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">

                <?php if (($ped['estado_pedido'] == 0 || $ped['estado_pedido'] == 1) && $ped['estado_pedido'] != NULL) {} else {?> 
                    <div id="boton_recibir<?php echo $ped['idpedidos_proveedor'] ?>" style="width: min-content;display: contents;"> 
                        <button disabled type="button" onclick="recibir_productos(<?php echo $ped['idpedidos_proveedor'] ?>)" class="btn btn-outline-success">Recibir</button>
                    </div>
                    <button type="button" onclick="cancelar_pedido(<?php echo $ped['idpedidos_proveedor'] ?>)" class="btn btn-outline-danger">Cancelar</button>
                <?php } ?>
                <table class="table" id="tabla<?php echo $ped['idpedidos_proveedor'] ?>">
                    <thead>
                    <tr>
                        <th scope="col">Producto</th>
                        <th scope="col">Cantidad</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Perro</td>
                        <td>7</td>
                    </tr>
                    </tbody>
                </table>
                </div>
            </div>
            </div>
    <?php } //fin del ciclo

    ?>

</div>

<?php //desconecta la base de datos

    $mysql->desconectar();

?>