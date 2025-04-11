<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //toma los valores deseados
    $idproveedor = $_POST['idproveedor'];

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $provedores = $mysql->efectuarConsulta("SELECT proveedor.idproveedor, 
    proveedor.nombre, 
    proveedor.telefono, 
    proveedor.cuenta_bancaria 
    FROM proveedor 
    WHERE proveedor.idproveedor = ".$idproveedor."");

    while ($prov = mysqli_fetch_array($provedores)) {
        # code...
    
    ?>

            <p>Aqui podras editar informacion de proveedores!</p>
              
              <div class="mb-3">
                
                <div class="input-group">
                  <span class="input-group-text" id="basic-addon1">Nombre: </span>
                  <input value="<?php echo $prov['nombre'] ?>" type="text" class="form-control" id="Nombre_proveedor_editar" placeholder="Nombre del proveedor" aria-describedby="basic-addon3 basic-addon4">
                </div>

              </div>

              <div class="mb-3">
                
                <div class="input-group">
                  <span class="input-group-text" id="basic-addon1">Telefono: </span>
                  <input value="<?php echo $prov['telefono'] ?>" type="text" class="form-control" id="Proveedor_telefono_edit" placeholder="opcional!" aria-describedby="basic-addon3 basic-addon4">
                </div>

              </div>

              <div class="mb-3">
                
                <div class="input-group">
                  <span class="input-group-text" id="basic-addon1">Cuenta Bancaria: </span>
                  <input value="<?php echo $prov['cuenta_bancaria'] ?>" type="text" class="form-control" id="Proveedor_banco_edit" placeholder="Tambien es opcional! :D" aria-describedby="basic-addon3 basic-addon4">
                </div>

                <input value="<?php echo $prov['idproveedor'] ?>" type="number" class="form-control d-none" id="id_proveedor_edit" placeholder="" aria-describedby="basic-addon3 basic-addon4">
                

              </div>


    <?php

}

    //desconecta la base de datos

    $mysql->desconectar();
?>