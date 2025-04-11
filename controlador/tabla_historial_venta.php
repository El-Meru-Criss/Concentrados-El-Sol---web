<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $deudores = $mysql->efectuarConsulta("SELECT clientes.nombre, clientes.idclientes, producto.nombre_producto,
	inventario.precio_publico, inventario_has_ventas.cantidad_vendida, producto.nombre_producto, ventas.fecha_venta,
    inventario_has_ventas.unidad_medida_idunidad_medida,
    inventario.precio_bulto,
    unidad_medida.nombre AS nombre_unidad,
    vendedores.nombre as nombre_vendedores,
    clientes.documento,
    ventas.idventas
    FROM inventario_has_ventas
    INNER JOIN unidad_medida ON inventario_has_ventas.unidad_medida_idunidad_medida = unidad_medida.idunidad_medida
    INNER JOIN inventario ON inventario_has_ventas.inventario_idinventario = inventario.idinventario
    INNER JOIN ventas ON inventario_has_ventas.ventas_idventas = ventas.idventas
    INNER JOIN clientes ON ventas.clientes_idclientes = clientes.idclientes
    INNER JOIN proveedor_has_producto ON inventario.proveedor_has_producto_producto_idproducto = proveedor_has_producto.producto_idproducto
    INNER JOIN producto ON proveedor_has_producto.producto_idproducto = producto.idproducto
    INNER JOIN vendedores ON ventas.vendedores_idvendedores = vendedores.idvendedores
    GROUP BY ventas.idventas");
?>

<div class="container-fluid m-4">
      
      <input type="text" class="form-control me-2 light-table-filter" id="searchInput" placeholder="Buscar...">

</div>

<?php //inicio del ciclo para ir colocando HTML


$contador = 0; // Variable contador para llevar el control de los elementos

while ($deud = mysqli_fetch_array($deudores)) {?>

    <div class="accordion-item" id="searchResults">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $deud['idventas'] ?>" aria-expanded="false" aria-controls="collapseOne">
                  <?php echo $deud['nombre'] ?> - <?php echo $deud['fecha_venta'] ?> - cc: <?php echo $deud['documento'] ?>
                </button>
              </h2>
              <div id="collapse<?php echo $deud['idventas'] ?>" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
              <br>  
              <h4>vendido por: <?php echo $deud['nombre_vendedores'] ?> </h4>
                <div class="table-responsive">
                    <table class="tabla-deudores">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>unidad de medida</th>
                                <th>Precio</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                                $compra = $mysql->efectuarConsulta("SELECT clientes.idclientes, producto.nombre_producto,
                                inventario.precio_publico, inventario_has_ventas.cantidad_vendida, ventas.fecha_venta,
                                inventario_has_ventas.unidad_medida_idunidad_medida,
                                unidad_medida.nombre AS nombre_unidad,inventario.precio_bulto
                                FROM inventario_has_ventas
                                INNER JOIN unidad_medida ON inventario_has_ventas.unidad_medida_idunidad_medida = unidad_medida.idunidad_medida
                                INNER JOIN inventario ON inventario_has_ventas.inventario_idinventario = inventario.idinventario
                                INNER JOIN ventas ON inventario_has_ventas.ventas_idventas = ventas.idventas
                                INNER JOIN clientes ON ventas.clientes_idclientes = clientes.idclientes
                                INNER JOIN proveedor_has_producto ON inventario.proveedor_has_producto_producto_idproducto = proveedor_has_producto.producto_idproducto
                                INNER JOIN producto ON proveedor_has_producto.producto_idproducto = producto.idproducto
                                WHERE ventas.idventas= '".$deud['idventas']."' 
                                GROUP BY unidad_medida.idunidad_medida, inventario.idinventario");
                                while ($comp = mysqli_fetch_array($compra)) {
                            ?>
                                <tr>

                                    <td><?php echo $comp['nombre_producto'] ?></td>
                                    <td><?php echo $comp['cantidad_vendida'] ?></td>
                                    <td><?php echo $comp['nombre_unidad'] ?></td>
                                    <?php if ($comp['unidad_medida_idunidad_medida'] == 1) { ?>
                                        <td><?php echo $comp['precio_publico'] ?></td>
                                    <?php } if ($comp['unidad_medida_idunidad_medida'] == 2) { ?>
                                        <td><?php echo $comp['precio_bulto'] ?></td>
                                    <?php } ?>
                                    <td><?php echo $comp['fecha_venta'] ?></td>

                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>

                        <tr>
                            <td>Total</td>
                            <?php

                            $total = $mysql->efectuarConsulta("SELECT  ventas.precio_total, 
                            estado_venta.nombre_estado
                            FROM ventas
                            INNER JOIN estado_venta ON ventas.estado_venta_idestado_venta = estado_venta.idestado_venta
                            WHERE ventas.idventas= '".$deud['idventas']."'  GROUP BY ventas.idventas");


                            while ($tot = mysqli_fetch_array($total)) { ?>
                            <td><?php echo $tot['precio_total'] ?></td>
                            <td>tipo de venta</td>
                            <td><?php echo $tot['nombre_estado'] ?></td>
                            <?php } ?>
                            <td></td>

                        </tr>
                        
                        </tfoot>
                    </table>
                </div>
               </div>
            </div>

<?php } //fin del ciclo
?>

<script>
  const searchInput = document.getElementById('searchInput');
  const searchResults = document.getElementById('searchResults');

  searchInput.addEventListener('input', handleSearch);

  function handleSearch() {
    const searchTerm = searchInput.value.toLowerCase();

    const accordions = document.getElementsByClassName('accordion-item');

    for (let i = 0; i < accordions.length; i++) {
      const accordionHeader = accordions[i].querySelector('.accordion-header');
      const itemName = accordionHeader.textContent.toLowerCase();

      if (searchTerm === '' || itemName.includes(searchTerm)) {
        accordions[i].style.display = 'block';
      } else {
        accordions[i].style.display = 'none';
      }
    }
  }
</script>


<?php //desconecta la base de datos
    $mysql->desconectar();
?>