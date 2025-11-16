<?php

// Respuesta JSON
header("Content-Type: application/json");

// Incluir conexión y modelo
require_once("../configuracion/conexion.php");
require_once("../modelos/Categoria.php");

// Instancia del modelo
$categoria = new Categoria();

// Obtener método HTTP
$metodo = $_SERVER["REQUEST_METHOD"];

// Obtener cuerpo JSON (si lo hay)
$body = json_decode(file_get_contents("php://input"), true);

// RUTA SIMPLE: /categoria?id=XXXX
$id = isset($_GET["id"]) ? $_GET["id"] : null;

switch ($metodo) {

    // GET → listar u obtener

    case "GET":

        if ($id) {
            // Obtener por id
            $datos = $categoria->obtener_categoria_por_id($id);
            echo json_encode($datos);
        } else {
            // Listar todas
            $datos = $categoria->obtener_categorias();
            echo json_encode($datos);
        }
        break;

    
    // POST → insertar
    
    case "POST":

        if (empty($body["id"]) || empty($body["nombre"])) {
            echo json_encode(["error" => "ID y nombre son obligatorios"]);
            exit();
        }

        // Validar ID duplicado
        $existe = $categoria->obtener_categoria_por_id($body["id"]);
        if ($existe) {
            echo json_encode(["error" => "El ID ya existe"]);
            exit();
        }

        $categoria->insertar_categoria($body["id"], $body["nombre"]);
        echo json_encode(["Correcto" => "Categoría creada"]);
        break;

    
    // PUT → actualizar
    
    case "PUT":

        if (empty($body["id"]) || empty($body["nombre"])) {
            echo json_encode(["error" => "ID y nombre son obligatorios"]);
            exit();
        }

        $categoria->actualizar_categoria($body["id"], $body["nombre"]);
        echo json_encode(["Correcto" => "Categoría actualizada"]);
        break;

    // DELETE → eliminar
    
    case "DELETE":

        if (!$id) {
            echo json_encode(["error" => "Debe enviar id en la URL"]);
            exit();
        }

        $categoria->eliminar_categoria($id);
        echo json_encode(["Correcto" => "Categoría eliminada"]);
        break;

    default:
        echo json_encode(["error" => "Método no permitido"]);
        break;
}

?>
