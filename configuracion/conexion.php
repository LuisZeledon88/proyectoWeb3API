<?php
// Clase Conectar para manejar la conexión a la base de datos
class Conectar {
    // Variable protegida para almacenar la instancia de la conexión
    protected $conexion_bd;
    
    // Método protegido para establecer la conexión con la base de datos
    protected function conectar_bd() {
        try {
            // DATOS DEL HOSTING
            $host = "mysql.railway.internal";
            $dbname = "railway";
            $user = "root";
            $pass = "YilaAliWBNXDbfTJbIwHbGnhdsvQMwuM";
            $port = 3306;

            // Conexión PDO
            $this->conexion_bd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            $this->conexion_bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this->conexion_bd;

        } catch (Exception $e) {
            // Si ocurre un error, muestra el mensaje de error y detiene la ejecución
            print "Error en la base de datos: " . $e->getMessage();
            die();
        }
    }

    // Método público para establecer la codificación de caracteres a UTF-8
    public function establecer_codificacion() {
        return $this->conexion_bd->query("SET NAMES 'utf8'");
    }
}
?>
