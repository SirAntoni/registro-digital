<?php

require "../config/conexion.php";
require "../model/Usuario.php";

$usuarios = new Usuarios();

$id = '';
$usuario = '';
$contrasena = '';
$nombres = '';
$apellidos = '';
$foto = '';
$firma = '';
$estado = '';
$rol = '';
$opcion = '';
$archivoFoto = '';
$archivoFirma = '';


if (isset($_POST['opcion']))
    $opcion = $_POST['opcion'];
if (isset($_POST['id']))
    $id = $_POST['id'];
if (isset($_POST['usuario']))
    $usuario = $_POST['usuario'];
if (isset($_POST['contrasena']))
    $contrasena = $_POST['contrasena'];
if (isset($_POST['nombres']))
    $nombres = $_POST['nombres'];
if (isset($_POST['apellidos']))
    $apellidos = $_POST['apellidos'];
if (isset($_POST['rol']))
    $rol = $_POST['rol'];
if (isset($_POST['estado']))
    $estado = $_POST['estado'];
if (!empty($_FILES['foto']['name']))
    $foto = $_FILES['foto']['name'];
if (!empty($_FILES['firma']['name']))
    $firma = $_FILES['firma']['name'];
if (isset($_POST['archivoFoto']))
    $archivoFoto = $_POST['archivoFoto'];
if (isset($_POST['archivoFirma']))
    $archivoFirma = $_POST['archivoFirma'];

switch ($opcion) {
    case 'agregar':
        echo json_encode($usuarios->crear_usuario($usuario, $contrasena, $nombres, $apellidos, $rol, $foto, $firma, $estado));
        break;
    case 'editar':
        echo json_encode($usuarios->editar_usuario($id, $usuario, $contrasena, $nombres, $apellidos, $rol, $foto, $firma, $estado, $archivoFoto, $archivoFirma));
        break;
    case 'eliminar':
        echo json_encode($usuarios->eliminar_usuario($id));
        break;
    case 'login':
        echo json_encode($usuarios->login($usuario, $contrasena));
        break;
    case 'obtener_perfil':
        echo json_encode($usuarios->obtener_perfil($_SESSION['id']));
        break;
    case 'editar_perfil':
        echo json_encode($usuarios->editar_perfil($_SESSION['id'],$contrasena,$nombres,$apellidos,$foto,$firma,$archivoFoto,$archivoFirma));
        break;
    default:
        echo json_encode($usuarios->listar_usuarios());
        break;
}