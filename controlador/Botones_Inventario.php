<?php 

//llamo el modelo
require '../modelo/usuarios.php';
//instancio la clase
$user = new Usuario();

//inicio sesion
session_start();

$usuario = $_SESSION['usuario'];

?> 

<div class="btn-group btn-group-lg" role="group" aria-label="Basic mixed styles example">

    <?php if ($usuario->getRol() == 1) {

        ?> 
        
            <button onclick="seleccionar_producto(); mostrar_provedores_producto();" type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#crear_productos"><i class="fa-solid fa-circle-plus"></i> Productos</button>
            <button onclick="provedores_renovar()" type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#Renovar"><i class="fa-sharp fa-solid fa-recycle"></i> Pedidos</button>
            <button onclick="mostrar_provedores()" type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#administrar_proovedores"><i class="fa-solid fa-address-card"></i> Proveedores</button>
            

        <?php
        
    } ?>

    <button onclick="MostrarAlertas()" type="button" class="btn btn-danger position-relative" data-bs-toggle="modal" data-bs-target="#buscar_producto">
    <i class="fa-solid fa-triangle-exclamation"></i> Alertas
    <span class="badge rounded-pill bg-dark" id="Numero_alertas">
        
    </span>
    </button>
</div>  

<?php

?>