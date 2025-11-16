<?php
class Usuarios extends Conectar {

    // Obtener la llave de encriptación usando la cédula del programador
    public function ObtenerLlavePorCedula($cedula) {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sql = "SELECT llave FROM usuarios WHERE cedula = ?";
        $consulta = $conexion->prepare($sql);
        $consulta->bindValue(1, $cedula);
        $consulta->execute();

        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        // Si encuentra la llave, la devuelve
        if ($resultado && isset($resultado["llave"])) {
            return $resultado["llave"];
        }

        // Si no existe usuario → false
        return false;
    }
}
?>
