<?php
session_start();
require "../config/conexion.php";
require "../model/Registro.php";

$registros = new Registros();

$id = '';
$opcion = '';
$usuario = '';
$promotor = '';
$tipo = '';
$indicativo = '';
$clasificacion = '';
$recibido = '';
$asunto = '';
$documento = '';
$decreto = '';
$observacion = '';
$path = '';

if (isset($_POST['path']))
    $path = $_POST['path'];

if (isset($_POST['opcion']))
    $opcion = $_POST['opcion'];
if (isset($_POST['id']))
    $id = $_POST['id'];
if (isset($_POST['validador']))
    $usuario = $_POST['validador'];
if (isset($_POST['promotor']))
    $promotor = $_POST['promotor'];
if (isset($_POST['tipo']))
    $tipo = $_POST['tipo'];
if (isset($_POST['indicativo']))
    $indicativo = $_POST['indicativo'];
if (isset($_POST['clasificacion']))
    $clasificacion = $_POST['clasificacion'];
if (isset($_POST['recibido']))
    $recibido = $_POST['recibido'];
if (isset($_POST['asunto']))
    $asunto = $_POST['asunto'];
if (!empty($_FILES['documento']['name']))
    $documento = $_FILES['documento']['name'];
if (isset($_POST['decreto']))
    $decreto = $_POST['decreto'];
if (isset($_POST['observacion']))
    $observacion = $_POST['observacion'];


switch ($opcion) {
    case 'agregar':
        echo json_encode($registros->crear_registro($_SESSION['id'],$documento, $promotor, $tipo, $indicativo, $clasificacion, $recibido, $asunto));
        break;
    case 'eliminar':
        echo json_encode($registros->eliminar_registro($_SESSION['rol'],$id));
        break;
    case 'firmar':
        echo json_encode($registros->firmar($id, $_SESSION['id'], $usuario, $decreto, $observacion));
        break;
    case 'firmarDestino':
        echo json_encode($registros->firmar_destino($id, $observacion));
        break;
    case 'obtener_registro':
        echo json_encode($registros->obtener_registro($id));
        break;
    case 'obtener_documento':
        echo json_encode($registros->obtener_documento($id));
        break;
    case 'restore':
        echo json_encode($registros->restore($path));
        break;
    default:
        echo json_encode($registros->listar_registros($_SESSION['id'], $_SESSION['rol']));
        break;
}