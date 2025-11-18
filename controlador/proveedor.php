<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, cedula");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}

header("Content-Type: application/json");

require_once("../configuracion/conexion.php");
require_once("../modelos/Proveedor.php");
require_once("../modelos/Usuarios.php");

$proveedor = new Proveedor();
$usuario = new Usuarios();

$CLAVE_DESENCRIPTACION = null;



$encabezados = array_change_key_case(getallheaders(), CASE_LOWER);

if (!isset($encabezados['cedula'])) {
    echo json_encode(["error" => "Acceso no autorizado - Falta encabezado 'cedula'"]);
    exit();
}

$CLAVE_DESENCRIPTACION = $usuario->ObtenerLlavePorCedula($encabezados['cedula']);

if ($CLAVE_DESENCRIPTACION === false) {
    echo json_encode(["error" => "Acceso no autorizado - Usuario no encontrado"]);
    exit();
}

function Desencriptar_BODY($JSON, $clave)
{
    $cifrado = "aes-256-ecb";

    return openssl_decrypt(
        base64_decode($JSON),
        $cifrado,
        $clave,
        OPENSSL_RAW_DATA
    );
}

if (!isset($_GET["op"])) {
    echo json_encode(["error" => "Debe indicar la operación (op)"]);
    exit();
}

$op = $_GET["op"];
$body = [];

$operaciones_con_body = ["Insertar", "Actualizar", "Eliminar", "ObtenerPorCedula"];

if (in_array($op, $operaciones_con_body)) {

    $body_encriptado = file_get_contents("php://input");
    $body_desencriptado = Desencriptar_BODY($body_encriptado, $CLAVE_DESENCRIPTACION);

    if ($body_desencriptado === false) {
        echo json_encode(["Error" => "Error al desencriptar los datos"]);
        exit();
    }

    $body = json_decode($body_desencriptado, true);

    if ($body === null) {
        echo json_encode(["Error" => "JSON inválido"]);
        exit();
    }
}

switch ($op) {

    case "ObtenerTodos":
        echo json_encode($proveedor->obtener_proveedores());
        break;

    case "ObtenerPorCedula":
        echo json_encode($proveedor->obtener_proveedor_por_id($body["cedula"]));
        break;

    case "Insertar":
        if (empty($body["cedula"]) || empty($body["nombre"])) {
            echo json_encode(["error" => "Cédula y nombre son obligatorios"]);
            exit();
        }

        if ($proveedor->obtener_proveedor_por_id($body["cedula"])) {
            echo json_encode(["error" => "La cédula ya existe"]);
            exit();
        }

        $proveedor->insertar_proveedor(
            $body["cedula"],
            $body["nombre"],
            $body["telefono"],
            $body["correo"],
            $body["direccion"]
        );

        echo json_encode(["Correcto" => "Proveedor registrado"]);
        break;

    case "Actualizar":
        $proveedor->actualizar_proveedor(
            $body["cedula"],
            $body["nombre"],
            $body["telefono"],
            $body["correo"],
            $body["direccion"]
        );

        echo json_encode(["Correcto" => "Proveedor actualizado"]);
        break;

    case "Eliminar":
        $proveedor->eliminar_proveedor($body["cedula"]);
        echo json_encode(["Correcto" => "Proveedor eliminado"]);
        break;

    default:
        echo json_encode(["error" => "Operación (op) no válida"]);
        break;
}
?>
