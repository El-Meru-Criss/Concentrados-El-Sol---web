<?php

require_once '../modelo/usuarios.php'; 

  session_start();
    unset($_SESSION['usuario']); 
  unset($_SESSION['acceso']);
  session_destroy();
  exit;

?>