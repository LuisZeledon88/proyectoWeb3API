<?php
class Usuarios extends Conectar {

    public function ObtenerLlavePorCedula($cedula) {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sql = "SELECT llave FROM usuarios WHERE cedula = ?";
        $consulta = $conexion->prepare($sql);
        $consulta->bindValue(1, $cedula);
        $consulta->execute();

        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado && isset($resultado["llave"])) {
            return $resultado["llave"];
        }

        return false;
    }
}
?>
