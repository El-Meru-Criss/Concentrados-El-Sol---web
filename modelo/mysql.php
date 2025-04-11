<?php
// Clase para conexiones a la base de datos
class MySQL {
    // Datos de conexión
    private $ipServidor = "ip"; //la ip de la BD o si esta en el mismo servidor, localhost
    private $usuarioBase = 'usuario'; //Usuario de la BD
    private $contraseña = 'contra'; //contraseña de la BD
    private $nombreBase = 'Nombre'; // Agrega el nombre de la base de datos

    private $conexion;
    private $resultadoConsulta;

    // Método para conectar a la base de datos
    public function conectar() {
        // Conectar a la base de datos especificada
        $this->conexion = mysqli_connect($this->ipServidor, $this->usuarioBase, $this->contraseña, $this->nombreBase);

        // Verificar si la conexión fue exitosa
        if (!$this->conexion) {
            die("Error en la conexión: " . mysqli_connect_error());
        }
    }

    // Método que cierra la conexión
    public function desconectar() {
        if ($this->conexion) {
            mysqli_close($this->conexion);
        }
    }

    // Método que efectúa una consulta y devuelve su resultado
    public function efectuarConsulta($consulta) {
        // Configurar la codificación y localización
        mysqli_query($this->conexion, "SET lc_time_names = 'es_ES'");
        mysqli_query($this->conexion, "SET NAMES 'utf8'");
        mysqli_query($this->conexion, "SET CHARACTER SET 'utf8'");

        // Ejecutar la consulta
        $this->resultadoConsulta = mysqli_query($this->conexion, $consulta);

        // Verificar si la consulta fue exitosa
        if (!$this->resultadoConsulta) {
            die("Error en la consulta: " . mysqli_error($this->conexion));
        }

        return $this->resultadoConsulta;
    }

    // Método para liberar el resultado de la consulta
    public function liberarResultado() {
        if ($this->resultadoConsulta) {
            mysqli_free_result($this->resultadoConsulta);
        }
    }
}
?>