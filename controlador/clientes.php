<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, cedula");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}


// Respuesta siempre JSON
header("Content-Type: application/json");

// Incluir conexión y modelo
require_once("../configuracion/conexion.php");
require_once("../modelos/Clientes.php");

// Instancia del modelo
$cliente = new Clientes();

// Obtener JSON del BODY
$body = json_decode(file_get_contents("php://input"), true);

// Validar parámetro op
if (!isset($_GET["op"])) {
    echo json_encode(["error" => "Debe indicar la operación (op)"]);
    exit();
}

switch ($_GET["op"]) {

    // =====================================
    // LISTAR TODOS
    // =====================================
    case "ObtenerTodos":
        $datos = $cliente->obtener_clientes();
        echo json_encode($datos);
        break;

    // =====================================
    // BUSCAR POR CÉDULA
    // =====================================
    case "ObtenerPorCedula":
        $datos = $cliente->obtener_cliente_por_id($body["cedula"]);
        echo json_encode($datos);
        break;

    // =====================================
    // INSERTAR
    // =====================================
    case "Insertar":

        if (empty($body["cedula"]) || empty($body["nombre"])) {
            echo json_encode(["error" => "Cédula y nombre son obligatorios"]);
            exit();
        }

        // Validar llave primaria
        $existe = $cliente->obtener_cliente_por_id($body["cedula"]);
        if ($existe) {
            echo json_encode(["error" => "La cédula ya existe"]);
            exit();
        }

        $cliente->insertar_cliente(
            $body["cedula"],
            $body["nombre"],
            $body["telefono"],
            $body["correo"],
            $body["direccion"]
        );

        echo json_encode(["Correcto" => "Cliente registrado"]);
        break;

    // =====================================
    // ACTUALIZAR
    // =====================================
    case "Actualizar":

        if (empty($body["cedula"])) {
            echo json_encode(["error" => "Debe enviar la cédula del cliente"]);
            exit();
        }

        $cliente->actualizar_cliente(
            $body["cedula"],
            $body["nombre"],
            $body["telefono"],
            $body["correo"],
            $body["direccion"]
        );

        echo json_encode(["Correcto" => "Cliente actualizado"]);
        break;

    // =====================================
    // ELIMINAR
    // =====================================
    case "Eliminar":

        if (empty($body["cedula"])) {
            echo json_encode(["error" => "Debe enviar la cédula del cliente"]);
            exit();
        }

        $cliente->eliminar_cliente($body["cedula"]);
        echo json_encode(["Correcto" => "Cliente eliminado"]);
        break;

    default:
        echo json_encode(["error" => "Operación no válida"]);
        break;
}

?>
