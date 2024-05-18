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

if (isset($_POST['opcion']))
    $opcion = $_POST['opcion'];
if (isset($_POST['id']))
    $id = $_POST['id'];
if (isset($_POST['usuario']))
    $usuario = $_POST['usuario'];
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

switch ($opcion) {
    case 'agregar':
        echo json_encode($registros->crear_registro($documento, $promotor, $tipo, $indicativo, $clasificacion, $recibido, $asunto));
        break;
    case 'firmar':
        echo json_encode($registros->firmar($id, $_SESSION['id']));
        break;
    case 'firmarDestino':
        echo json_encode($registros->firmar_destino($id, $_SESSION['id']));
        break;
    case 'eliminar':
        echo json_encode($usuarios->eliminar_usuario($id));
        break;
    default:
        echo json_encode($registros->listar_registros($_SESSION['id'], $_SESSION['rol']));
        break;
}