<?php

class Usuario {
    

    private $Usuario;
    private $idusuarios;
    private $CC;
    private $Contrasena;
    private $Rol;
    
   // private $roles_idroles;



    public function __construct(){}

    //recibame el Usuario
    public function setUsuario($Usuario){
        $this->Usuario = $Usuario;
    }

    //recibame el idusuarios
    public function setIdusuarios($idusuarios){
        $this->idusuarios = $idusuarios;
    }

    //recibame el CC
    public function setCC($CC){
        $this->CC = $CC;
    }

    //recibame el Contrasena
    public function setContrasena($Contrasena){
        $this->Contrasena = $Contrasena;
    }

    //recibame el Rol
    public function setRol($Rol){
        $this->Rol = $Rol;
    }

    //Entrega lo que este en la clase

    public function getUsuario(){
        return $this->Usuario;
    }

    public function getIdusuarios(){
        return $this->idusuarios;
    }

    public function getCC(){
        return $this->CC;
    }

    public function getContrasena(){
        return $this->Contrasena;
    }

    public function getRol(){
        return $this->Rol;
    }

    // public function getRoles_idroles(){
    //     return $this->roles_idroles;
    // }

}
?>