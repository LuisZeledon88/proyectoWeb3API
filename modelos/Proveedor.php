<?php
class Proveedor extends Conectar {

    public function obtener_proveedores() {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sql = "SELECT * FROM proveedor";
        $consulta = $conexion->prepare($sql);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_proveedor_por_id($cedula) {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sql = "SELECT * FROM proveedor WHERE cedula = ?";
        $consulta = $conexion->prepare($sql);
        $consulta->bindValue(1, $cedula);
        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    public function insertar_proveedor($cedula, $nombre, $telefono, $correo, $direccion) {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sql = "INSERT INTO proveedor VALUES (?, ?, ?, ?, ?)";
        $consulta = $conexion->prepare($sql);
        $consulta->execute([$cedula, $nombre, $telefono, $correo, $direccion]);
    }

    public function actualizar_proveedor($cedula, $nombre, $telefono, $correo, $direccion) {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sql = "UPDATE proveedor 
                SET nombre=?, telefono=?, correo=?, direccion=?
                WHERE cedula=?";
        $consulta = $conexion->prepare($sql);
        $consulta->execute([$nombre, $telefono, $correo, $direccion, $cedula]);
    }

    public function eliminar_proveedor($cedula) {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sql = "DELETE FROM proveedor WHERE cedula=?";
        $consulta = $conexion->prepare($sql);
        $consulta->execute([$cedula]);
    }
}
?>
