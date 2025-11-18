<?php
class Conectar {
    protected $conexion_bd;
        protected function conectar_bd() {
        try {
            $host = "mysql.railway.internal";
            $dbname = "railway";
            $user = "root";
            $pass = "YilaAliWBNXDbfTJbIwHbGnhdsvQMwuM";
            $port = 3306;

            $this->conexion_bd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            $this->conexion_bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this->conexion_bd;

        } catch (Exception $e) {
            print "Error en la base de datos: " . $e->getMessage();
            die();
        }
    }

    public function establecer_codificacion() {
        return $this->conexion_bd->query("SET NAMES 'utf8'");
    }
}
?>
