<?php
class Clientes extends Conectar {

    public function obtener_clientes() {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sql = "SELECT * FROM clientes";
        $consulta = $conexion->prepare($sql);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_cliente_por_id($cedula) {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sql = "SELECT * FROM clientes WHERE cedula = ?";
        $consulta = $conexion->prepare($sql);
        $consulta->bindValue(1, $cedula);
        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    public function insertar_cliente($cedula, $nombre, $telefono, $correo, $direccion) {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sql = "INSERT INTO clientes VALUES (?, ?, ?, ?, ?)";
        $consulta = $conexion->prepare($sql);
        $consulta->execute([$cedula, $nombre, $telefono, $correo, $direccion]);
    }

    public function actualizar_cliente($cedula, $nombre, $telefono, $correo, $direccion) {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sql = "UPDATE clientes 
                SET nombre=?, telefono=?, correo=?, direccion=?
                WHERE cedula=?";
        $consulta = $conexion->prepare($sql);
        $consulta->execute([$nombre, $telefono, $correo, $direccion, $cedula]);
    }

    public function eliminar_cliente($cedula) {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sql = "DELETE FROM clientes WHERE cedula=?";
        $consulta = $conexion->prepare($sql);
        $consulta->execute([$cedula]);
    }
}
?>
