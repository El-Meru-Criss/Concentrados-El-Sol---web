<?php 

//llamo el modelo
require '../modelo/usuarios.php';
//instancio la clase
$user = new Usuario();

//inicio sesion
session_start();
//defino los parametros de inicio de sesion

if (empty($_SESSION['usuario']) && empty($_SESSION['acceso'])) {
    # Si no esta registrado

    echo "ECHAR";
} else {
    # Si esta registrado

    $usuario = $_SESSION['usuario'];

    ?>

    <h2><?php echo $usuario->getUsuario(); ?></h2> 
    <div class="input-group p-1">
        <span class="input-group-text" id="basic-addon1">Identificacion:</span>
        <input disabled="" min="0" type="text" value="<?php echo $usuario->getCC(); ?>" class="form-control">
    </div>
  
    <div class="input-group p-1">
        <span class="input-group-text" id="basic-addon1">Contraseña:</span>
        <input min="0" disabled="" type="password" class="form-control" value="<?php echo $usuario->getContrasena(); ?>">
        <button type="button" class="btn btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
        <button type="button" class="btn btn-outline-dark"><i class="fa-solid fa-eye"></i></button>
    </div>

    <div class="input-group p-1">
        <span class="input-group-text" id="basic-addon1">Rol:</span>
        <input disabled="" min="0" type="text" value="<?php if ($usuario->getRol() == 1) {echo "Administrador";} else {echo "Vendedor";} ?>" class="form-control">
    </div>
  
  


    <?php
}

?>