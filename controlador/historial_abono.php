<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    $idventas = $_POST['idventas'];

   //realiza la consulta MySQL deseada, y la guarda en una variable
    $abonos = $mysql->efectuarConsulta("SELECT historial_abonos.fecha_abono,
    historial_abonos.cantidad_abonada     
    FROM historial_abonos
    INNER JOIN cartera ON historial_abonos.cartera_idcartera = cartera.idcartera
    WHERE cartera.ventas_idventas = '".$idventas."' ");
?>

<div class="table-responsive">
                    <center>
                    <table class="">
                        <thead>
                            <tr>
                                <th>Fecha Abono</th>
                                <th>Cantidad Abonada</th>
                            </tr>
                        </thead>

<?php
    while ($abo = mysqli_fetch_array($abonos)) { 
        ?> 
                
                        <tbody>
                            <tr>
                                <td style="text-align: center;"><?php echo $abo['fecha_abono'] ?></td>
                                <td style="text-align: center;"><?php echo $abo['cantidad_abonada'] ?></td>
                            </tr>
                        </tbody>
                        
        
        
        <?php
    } ?>
                        <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table>
                    </center>
                    
                </div>
    <?php

    $mysql->desconectar();
?>