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

    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal"><i
    class="fa-solid fa-book"></i> <a href="historial_ventas.html"
    style="text-decoration:none;color:inherit;">historial</a></button>

    <?php if ($usuario->getRol() == 1) {

        ?> 
        
        <button class="btn btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#mostar_vendedores"
          aria-expanded="false" onclick="mostrar_vendedores()"><i class="fa-solid fa-address-card"></i> vendedores
        </button>
            

        <?php
        
    } ?>

    <button class="btn btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#mostar_clientes"
    aria-expanded="false" onclick="mostrar_clientes()"><i class="fa-solid fa-address-card"></i> clientes </button>
</div>  

<?php

?>