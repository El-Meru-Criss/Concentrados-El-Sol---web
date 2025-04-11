<?php 
    function calcularDiferencia($fecha1, $fecha2) {
        // Crear objetos DateTime con las fechas
        $date1 = new DateTime($fecha1);
        $date2 = new DateTime($fecha2);
    
        // Obtener los timestamps de las fechas
        $timestamp1 = $date1->getTimestamp();
        $timestamp2 = $date2->getTimestamp();
    
        // Calcular la diferencia en segundos
        $diferencia = $timestamp2 - $timestamp1;
    
        // Convertir la diferencia en meses y días
        $meses = floor($diferencia / (30 * 24 * 60 * 60));
        $dias = floor(($diferencia) / (24 * 60 * 60));
    
        return array('meses' => $meses, 'dias' => $dias);
    }

    $fechaActual = date('Y-m-d');

    //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $deudores = $mysql->efectuarConsulta("SELECT clientes.nombre,clientes.telefono,clientes.direccion,clientes.correo,clientes.documento,clientes.idclientes, producto.nombre_producto,
	inventario.precio_publico, inventario_has_ventas.cantidad_vendida, producto.nombre_producto, ventas.fecha_venta,
    inventario_has_ventas.unidad_medida_idunidad_medida,
    inventario.precio_bulto,
    unidad_medida.nombre AS nombre_unidad,
    ventas.idventas,
    vendedores.nombre AS vendedor
    FROM inventario_has_ventas
    INNER JOIN unidad_medida ON inventario_has_ventas.unidad_medida_idunidad_medida = unidad_medida.idunidad_medida
    INNER JOIN inventario ON inventario_has_ventas.inventario_idinventario = inventario.idinventario
    INNER JOIN ventas ON inventario_has_ventas.ventas_idventas = ventas.idventas
    INNER JOIN clientes ON ventas.clientes_idclientes = clientes.idclientes
    INNER JOIN vendedores ON ventas.vendedores_idvendedores = vendedores.idvendedores
    INNER JOIN proveedor_has_producto ON inventario.proveedor_has_producto_producto_idproducto = proveedor_has_producto.producto_idproducto
    INNER JOIN producto ON proveedor_has_producto.producto_idproducto = producto.idproducto
    WHERE ventas.estado_venta_idestado_venta=2 GROUP BY ventas.idventas");

        
        

?>
<div class="container-fluid m-4"><input type="text" class="form-control me-2 light-table-filter" id="searchInput" placeholder="Buscar..."></div>
<?php //inicio del ciclo para ir colocando HTML

while ($deud = mysqli_fetch_array($deudores)) { 
    $comparacion = calcularDiferencia($fechaActual, $deud['fecha_venta']);
    ?>

    <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed <?php if ($comparacion['dias'] <= -15) {
        ?> text-white bg-danger <?php
    }; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $deud['idventas'] ?>" aria-expanded="false" aria-controls="collapseOne">
                 <?php echo $deud['documento'] ?> - <?php echo $deud['nombre'] ?> - (<?php echo $deud['fecha_venta'] ?>)
                </button>
              </h2>
              <div id="collapse<?php echo $deud['idventas'] ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="table-responsive">
                    <table class="tabla-deudores">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Unidad de medida</th>
                                <th>Precio</th>
                                <th>Vendedor</th>
                                
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                                $compra = $mysql->efectuarConsulta("SELECT clientes.idclientes, producto.nombre_producto,
                                inventario.precio_publico, inventario_has_ventas.cantidad_vendida, ventas.fecha_venta,
                                inventario_has_ventas.unidad_medida_idunidad_medida,
                                unidad_medida.nombre AS nombre_unidad,inventario.precio_bulto,
                                vendedores.nombre AS vendedor
                                FROM inventario_has_ventas
                                INNER JOIN unidad_medida ON inventario_has_ventas.unidad_medida_idunidad_medida = unidad_medida.idunidad_medida
                                INNER JOIN inventario ON inventario_has_ventas.inventario_idinventario = inventario.idinventario
                                INNER JOIN ventas ON inventario_has_ventas.ventas_idventas = ventas.idventas
                                INNER JOIN clientes ON ventas.clientes_idclientes = clientes.idclientes
                                INNER JOIN vendedores ON ventas.vendedores_idvendedores = vendedores.idvendedores
                                INNER JOIN proveedor_has_producto ON inventario.proveedor_has_producto_producto_idproducto = proveedor_has_producto.producto_idproducto
                                INNER JOIN producto ON proveedor_has_producto.producto_idproducto = producto.idproducto
                                WHERE ventas.estado_venta_idestado_venta=2 AND ventas.idventas= '".$deud['idventas']."' 
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
                                    <td><?php echo $comp['vendedor'] ?></td>
                                    

                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>

                        <tr>
                            <td>Total</td>
                            <?php

                            $total = $mysql->efectuarConsulta("SELECT  cartera.cantidad_debida AS total_deuda,
                            cartera.cantidad_abonada AS abonado
                            FROM cartera
                            INNER JOIN clientes ON cartera.clientes_idclientes = clientes.idclientes
                            INNER JOIN ventas ON cartera.ventas_idventas = ventas.idventas
                            WHERE ventas.estado_venta_idestado_venta=2 AND ventas.idventas= '".$deud['idventas']."'  GROUP BY ventas.idventas");


                            while ($tot = mysqli_fetch_array($total)) { ?>
                            <td><?php echo $tot['total_deuda'] ?></td>
                            <?php } ?>

                            <td>Abonado</td>
                            <?php
                             $total = $mysql->efectuarConsulta("SELECT  cartera.cantidad_debida AS total_deuda,
                             cartera.cantidad_abonada AS abonado
                             FROM cartera
                             INNER JOIN clientes ON cartera.clientes_idclientes = clientes.idclientes
                             INNER JOIN ventas ON cartera.ventas_idventas = ventas.idventas
                             WHERE ventas.estado_venta_idestado_venta=2 AND ventas.idventas= '".$deud['idventas']."'  GROUP BY ventas.idventas"); 
                            while ($abon = mysqli_fetch_array($total)) { ?>
                            <td><?php echo $abon['abonado'] ?></td>
                            <?php } ?>

                            <td>
                                <button type="button" class="btn btn-light" onclick="historial_abono(<?php echo $deud['idventas'] ?>)">Historial</button>
                            </td>
                            



                        </tr>
                        <tr>
                            <?php   
                                
                                    $abona = $mysql->efectuarConsulta("SELECT  cartera.cantidad_debida,
                                    cartera.cantidad_abonada, ventas.idventas
                                    FROM cartera
                                    INNER JOIN clientes ON cartera.clientes_idclientes = clientes.idclientes
                                    INNER JOIN ventas ON cartera.ventas_idventas = ventas.idventas
                                    WHERE ventas.estado_venta_idestado_venta=2 AND ventas.idventas= '".$deud['idventas']."'  GROUP BY ventas.idventas");

                                    
                                    
                             while ($abon = mysqli_fetch_array($abona)) { ?>
                            <?php  
                                    $abono_t = $abon['cantidad_abonada'];
                                    $debido_t = $abon['cantidad_debida'];
                                if($abono_t != $debido_t) {
                            ?>
                            <button type="button" class="btn btn-success m-1" onclick="abonar(<?php echo $abon['cantidad_abonada'] ?>, <?php echo $abon['idventas'] ?>,<?php echo $abon['cantidad_debida'] ?> )">Abonar</button>
                            <?php
                                } 
                            ?>
                            

                            <?php  
                                    $abono_t = $abon['cantidad_abonada'];
                                    $debido_t = $abon['cantidad_debida'];
                                if($abono_t == $debido_t) {
                            ?>
                                <button type="button" class="btn btn-danger m-1" onclick="eliminardeudor(<?php echo $deud['idventas'] ?>)">Terminar deuda</button>
                            <?php
                                } 
                            ?>

                            <button type="button" onclick="info_cliente('<?php echo $deud['nombre'] ?>','<?php echo $deud['telefono'] ?>','<?php echo $deud['direccion'] ?>','<?php echo $deud['correo'] ?>','<?php echo $deud['documento'] ?>')" class="btn btn-primary">Información</button>

                            <?php } 
                               
                            ?>
                                
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