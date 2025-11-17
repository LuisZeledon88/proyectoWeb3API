<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Credentials: true");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

header("Content-Type: application/json");

// ===============================
// ARCHIVOS DEL MODELO
// ===============================
require_once("../configuracion/conexion.php");
require_once("../modelos/Categoria.php");

$categoria = new Categoria();

$metodo = $_SERVER["REQUEST_METHOD"];
$body = json_decode(file_get_contents("php://input"), true);

// Ruta: /categoria.php?id=XX
$id = $_GET["id"] ?? null;

// ===============================
// RUTEO REST COMPLETO
// ===============================
switch ($metodo) {

    // ============================
    // GET → listar o traer uno
    // ============================
    case "GET":

        if ($id) {
            $datos = $categoria->obtener_categoria_por_id($id);

            if ($datos) {
                echo json_encode($datos);
            } else {
                echo json_encode(["error" => "No se encontró la categoría"]);
            }

        } else {
            $datos = $categoria->obtener_categorias();
            echo json_encode($datos);
        }
        break;


    // ============================
    // POST → insertar
    // ============================
    case "POST":

        if (empty($body["id"]) || empty($body["nombre"])) {
            echo json_encode(["error" => "ID y nombre son obligatorios"]);
            exit();
        }

        // Revisar duplicado
        if ($categoria->obtener_categoria_por_id($body["id"])) {
            echo json_encode(["error" => "El ID ya existe"]);
            exit();
        }

        $categoria->insertar_categoria($body["id"], $body["nombre"]);
        echo json_encode(["success" => true, "mensaje" => "Categoría creada"]);
        break;


    // ============================
    // PUT → actualizar
    // ============================
    case "PUT":

        if (empty($body["id"]) || empty($body["nombre"])) {
            echo json_encode(["error" => "ID y nombre son obligatorios"]);
            exit();
        }

        $categoria->actualizar_categoria($body["id"], $body["nombre"]);
        echo json_encode(["success" => true, "mensaje" => "Categoría actualizada"]);
        break;


    // ============================
    // DELETE → eliminar
    // ============================
    case "DELETE":

        if (!$id) {
            echo json_encode(["error" => "Debe enviar id por URL"]);
            exit();
        }

        $categoria->eliminar_categoria($id);
        echo json_encode(["success" => true, "mensaje" => "Categoría eliminada"]);
        break;


    default:
        echo json_encode(["error" => "Método no permitido"]);
        break;
}
?>
