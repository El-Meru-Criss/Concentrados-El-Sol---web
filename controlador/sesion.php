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
    <button onclick="cerrar_sesion(<?php echo $usuario->getIdusuarios(); ?>,'<?php echo $usuario->getUsuario(); ?>','<?php echo $usuario->getCC(); ?>','<?php echo $usuario->getContrasena(); ?>','<?php echo $usuario->getRol(); ?>')" type="button" class="btn btn-dark"><i class="fa-solid fa-user"></i> <?php echo $usuario->getUsuario(); ?></button>
    <?php
}

?>