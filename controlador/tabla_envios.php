<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $deudores = $mysql->efectuarConsulta("SELECT 
    inventario_has_ventas.ventas_idventas,
    inventario_has_ventas.inventario_idinventario,
    estado_domicilio.nombre_estado,
    clientes.nombre,
    clientes.telefono,
    clientes.direccion,
    clientes.correo,
    clientes.documento,
    inventario_has_ventas.cantidad_vendida,
    inventario.precio_publico,
    ventas.fecha_venta,
    clientes.idclientes,
    inventario_has_ventas.unidad_medida_idunidad_medida,
    inventario.precio_bulto,
    unidad_medida.nombre AS nombre_unidad,
    ventas.idventas
    FROM inventario_has_ventas
    INNER JOIN unidad_medida ON inventario_has_ventas.unidad_medida_idunidad_medida = unidad_medida.idunidad_medida
    INNER JOIN estado_domicilio ON inventario_has_ventas.estado_domicilio_idestado_domicilio = estado_domicilio.idestado_domicilio
    INNER JOIN ventas ON inventario_has_ventas.ventas_idventas = ventas.idventas
    INNER JOIN clientes ON ventas.clientes_idclientes = clientes.idclientes
    INNER JOIN inventario ON inventario_has_ventas.inventario_idinventario = inventario.idinventario
    WHERE inventario_has_ventas.estado_domicilio_idestado_domicilio=1
    OR inventario_has_ventas.estado_domicilio_idestado_domicilio=3
    GROUP BY  inventario_has_ventas.ventas_idventas");
       // $abonado = $mysql->efectuarConsulta("SELECT * FROM cantidad_pagada WHERE cantidad_pagada.dinero >= 0");
        
    $contador = 0;       

?>
<div class="container-fluid m-4"><input type="text" class="form-control me-2 light-table-filter" id="searchInput" placeholder="Buscar..."></div>
<?php //inicio del ciclo para ir colocando HTML 

while ($deud = mysqli_fetch_array($deudores)) { ?>
    
    <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $deud['ventas_idventas'] ?>" aria-expanded="false" aria-controls="collapseOne">
                <?php echo $deud['documento'] ?> - <?php echo $deud['nombre'] ?> - (<?php echo $deud['fecha_venta'] ?>)
              </h2>
              <div id="collapse<?php echo $deud['ventas_idventas'] ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="table-responsive">
                    <table class="tabla-deudores">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                
                                <th scope="col">Cantidad enviada</th>
                                <th>Faltante</th>
                                <th>Unidad de medida</th>
                                <th>Precio</th>
                                <th>¿Enviado?</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                                 $compra = $mysql->efectuarConsulta("SELECT clientes.nombre, 
                                 clientes.idclientes, 
                                 producto.nombre_producto,
                                 inventario.precio_publico, 
                                 inventario_has_ventas.cantidad_vendida,
                                 inventario_has_ventas.cantidad_enviada, 
                                 ventas.fecha_venta,
                                 inventario_has_ventas.estado_domicilio_idestado_domicilio,
                                 inventario_has_ventas.inventario_idinventario,
                                 inventario_has_ventas.ventas_idventas,
                                 inventario_has_ventas.unidad_medida_idunidad_medida,
                                 inventario.precio_bulto,
                                 unidad_medida.nombre AS nombre_unidad,
                                 ventas.idventas
                                 FROM inventario_has_ventas
                                 INNER JOIN unidad_medida ON inventario_has_ventas.unidad_medida_idunidad_medida = unidad_medida.idunidad_medida
                                 INNER JOIN inventario ON inventario_has_ventas.inventario_idinventario = inventario.idinventario
                                 INNER JOIN ventas ON inventario_has_ventas.ventas_idventas = ventas.idventas
                                 INNER JOIN clientes ON ventas.clientes_idclientes = clientes.idclientes
                                 INNER JOIN proveedor_has_producto ON inventario.proveedor_has_producto_producto_idproducto = proveedor_has_producto.producto_idproducto
                                 INNER JOIN producto ON proveedor_has_producto.producto_idproducto = producto.idproducto
                                 WHERE inventario_has_ventas.ventas_idventas= '".$deud['ventas_idventas']."'
                                 AND (inventario_has_ventas.estado_domicilio_idestado_domicilio=1
                                 OR inventario_has_ventas.estado_domicilio_idestado_domicilio=3) 
                                 GROUP BY unidad_medida.idunidad_medida, inventario.idinventario
                                  ");
                                  
                                  
                                 while ($comp = mysqli_fetch_array($compra)) { $contador += 1; $faltante= $comp['cantidad_vendida'] - $comp['cantidad_enviada']; $maxcan= $comp['cantidad_vendida'];
                            ?>
                                <tr>
                                
                                    <td><?php echo $comp['nombre_producto'] ?></td>
                                    <td><?php echo $comp['cantidad_vendida'] ?></td>
                                    <td><input onchange="cantidadEN_envios(<?php echo $comp['inventario_idinventario']?>,<?php echo $comp['ventas_idventas']?>,<?php echo $comp['cantidad_vendida']?>)" min="0" max="<?php echo $maxcan?>" value="<?php echo $comp['cantidad_enviada'] ?>" type="number" class="form-control form-control-sm" id="cantidad_enviada<?php echo $comp['inventario_idinventario']?><?php echo $comp['ventas_idventas']?><?php echo $comp['cantidad_vendida']?>" style="width: 10rem;"></td>
                                    <td><?php echo $faltante ?></td>
                                    <td><?php echo $comp['nombre_unidad'] ?></td>
                                    <?php if ($comp['unidad_medida_idunidad_medida'] == 1) { ?>
                                        <td><?php echo $comp['precio_publico'] ?></td>
                                    <?php } if ($comp['unidad_medida_idunidad_medida'] == 2) { ?>
                                        <td><?php echo $comp['precio_bulto'] ?></td>
                                    <?php } ?>
                                    
                                    <td>
                                    <input type="checkbox" id="checkenvio<?php echo $contador ?>" onclick="checkenvio(<?php echo $comp['unidad_medida_idunidad_medida'] ?>,<?php echo $comp['inventario_idinventario'] ?>,<?php echo $comp['ventas_idventas'] ?>,<?php echo $comp['estado_domicilio_idestado_domicilio'] ?> )" 
                                    <?php if ($comp['estado_domicilio_idestado_domicilio'] == 3) { ?>
                                        checked
                                    <?php } ?>
                                    disabled>
                                    </td> 
                                    
                                </tr>
                                   
                            <?php  }
                            ?>
                        </tbody>
                        <tfoot>
                            
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <button class="btn btn-danger" onclick="eliminarenvio(<?php echo $deud['ventas_idventas'] ?>)">Todo enviado</button>
                            <button type="button" onclick="info_cliente('<?php echo $deud['nombre'] ?>','<?php echo $deud['telefono'] ?>','<?php echo $deud['direccion'] ?>','<?php echo $deud['correo'] ?>','<?php echo $deud['documento'] ?>')" class="btn btn-primary">Información</button>

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