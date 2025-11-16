<?php
class Categoria extends Conectar {

    public function obtener_categorias() {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sql = "SELECT * FROM categoria";
        $consulta = $conexion->prepare($sql);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_categoria_por_id($id) {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sql = "SELECT * FROM categoria WHERE id = ?";
        $consulta = $conexion->prepare($sql);
        $consulta->bindValue(1, $id);
        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    public function insertar_categoria($id, $nombre) {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sql = "INSERT INTO categoria VALUES (?, ?)";
        $consulta = $conexion->prepare($sql);
        $consulta->execute([$id, $nombre]);
    }

    public function actualizar_categoria($id, $nombre) {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sql = "UPDATE categoria SET nombre=? WHERE id=?";
        $consulta = $conexion->prepare($sql);
        $consulta->execute([$nombre, $id]);
    }

    public function eliminar_categoria($id) {
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

        $sql = "DELETE FROM categoria WHERE id=?";
        $consulta = $conexion->prepare($sql);
        $consulta->execute([$id]);
    }
}
?>
