<?php
// Llama a la base de datos con el modelo
require_once '../modelo/mysql.php';
$mysql = new MySQL();

try {
    $mysql->conectar();

    // Toma los valores deseados
    $cc = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];
    $ingresa = "No";

    // Realiza la consulta MySQL deseada y la guarda en una variable
    $existencia = $mysql->efectuarConsulta("SELECT idvendedores, nombre, CC, contraseña, rol
                                            FROM u318418490_sol.vendedores 
                                            WHERE contraseña = '".$contraseña."' AND CC = '".$cc."'");

    if (mysqli_num_rows($existencia) > 0) {
        $ingresa = "Si";

        require_once '../modelo/usuarios.php';
        session_start();
        $usuario = new usuario();

        while($resultado = mysqli_fetch_assoc($existencia)) {
            $Nombre = $resultado["nombre"];
            $idusuarios = $resultado["idvendedores"];
            $CC = $resultado["CC"];
            $contraseña = $resultado["contraseña"];
            $rol = $resultado["rol"];

            // Ingresar los valores a la clase
            $usuario->setUsuario($Nombre);
            $usuario->setIdusuarios($idusuarios);
            $usuario->setCC($CC);
            $usuario->setContrasena($contraseña);
            $usuario->setRol($rol);
        }

        $_SESSION['usuario'] = $usuario;
        $_SESSION['acceso'] = true;
    }

    echo $ingresa;

    // Liberar el resultado y desconectar la base de datos
    $mysql->liberarResultado();
    $mysql->desconectar();

} catch (Exception $e) {
    // Manejo de errores
    error_log($e->getMessage());
    echo "Error al procesar la solicitud, por favor intenta más tarde.";
}
?>