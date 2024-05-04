<?php
session_start();
class Usuarios extends Conectar
{

    private $db;

    public function __construct()
    {
        $this->db = Conectar::conexion();
    }

    public function login($usuario, $contrasena)
    {
        $sql = "SELECT * FROM usuarios WHERE usuario = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $usuario);
        $sql->execute();

        if ($sql->rowCount() === 0)
            return ["status" => "error", "message" => "El usuario no existe."];

        $data = $sql->fetch(PDO::FETCH_ASSOC);
        $contrasenaEncriptada = $data['contrasena'];

        if($data['estado'] === 'inactivo' || $data['estado'] === 'eliminado') return ["status" => "error", "message" => "El usuario esta inactivo."];

        if (password_verify($contrasena, $contrasenaEncriptada) == false)
            return ["status" => "error", "message" => "Contraseña incorrecta."];

        $_SESSION['id'] = $data['id'];
        $_SESSION['usuario'] = $data['usuario'];
        $_SESSION['nombres'] = $data['nombres'];
        $_SESSION['apellidos'] = $data['apellidos'];
        $_SESSION['foto'] = $data['foto'];
        $_SESSION['firma'] = $data['firma'];
        $_SESSION['rol'] = $data['rol'];
        $_SESSION['estado'] = $data['estado'];


        return [
            "status" => "success",
            "url" => "index?view=registros"
        ];

    }

    public function listar_usuarios()
    {

        $sql = "SELECT * FROM usuarios WHERE estado NOT IN 
        ('eliminado')";
        $sql = $this->db->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);

    }

    public function listar_validadores()
    {

        $sql = "SELECT id,nombres,apellidos FROM usuarios WHERE rol = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1,3);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);

    }

    public function obtener_perfil($id)
    {

        $sql = "SELECT id,usuario,nombres,apellidos,foto,firma,rol FROM usuarios WHERE id = ? LIMIT 1";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1,$id);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC);

    }

    public function editar_perfil($id, $contrasena, $nombres, $apellidos, $foto, $firma, $archivoFoto, $archivoFirma)
    {

        if (empty($nombres) || empty($apellidos))
            return [
                "status" => "error",
                "message" => "Verifique los campos vacios."
            ];

        if (empty($contrasena)) {
            $sql = "UPDATE usuarios SET nombres = ?, apellidos = ?, foto = ?, firma = ?, updated_at = now() WHERE id = ?";
            $sql = $this->db->prepare($sql);

            if (empty($foto)) {
                $nombreFoto = $archivoFoto;
            } else {
                $nombreFoto = uniqid() . "-" . $_FILES["foto"]['name'];
                $ruta = "../img/fotos/" . $nombreFoto;
                move_uploaded_file($_FILES["foto"]['tmp_name'], $ruta);
            }

            if (empty($firma)) {
                $nombreFirma = $archivoFirma;
            } else {
                $nombreFirma = uniqid() . "-" . $_FILES["firma"]['name'];
                $ruta = "../img/firmas/" . $nombreFirma;
                move_uploaded_file($_FILES["firma"]['tmp_name'], $ruta);
            }

            $sql->bindValue(1, $nombres);
            $sql->bindValue(2, $apellidos);
            $sql->bindValue(3, $nombreFoto);
            $sql->bindValue(4, $nombreFirma);
            $sql->bindValue(5, $id);
            $sql->execute();

            return [
                "status" => "success",
                "message" => "Usuario editado correctamente."
            ];

        } else {
            $sql = "UPDATE usuarios SET contrasena = ?, nombres = ?, apellidos = ?, foto = ?, firma = ?, updated_at = now() WHERE id = ?";
            $sql = $this->db->prepare($sql);
            $contrasenaEncriptada = password_hash($contrasena, PASSWORD_DEFAULT);

            if (empty($foto)) {
                $nombreFoto = $archivoFoto;
            } else {
                $nombreFoto = uniqid() . "-" . $_FILES["foto"]['name'];
                $ruta = "../img/fotos/" . $nombreFoto;
                move_uploaded_file($_FILES["foto"]['tmp_name'], $ruta);
            }

            if (empty($firma)) {
                $nombreFirma = $archivoFirma;
            } else {
                $nombreFirma = uniqid() . "-" . $_FILES["firma"]['name'];
                $ruta = "../img/firmas/" . $nombreFirma;
                move_uploaded_file($_FILES["firma"]['tmp_name'], $ruta);
            }

            $sql->bindValue(1, $contrasenaEncriptada);
            $sql->bindValue(2, $nombres);
            $sql->bindValue(3, $apellidos);
            $sql->bindValue(4, $nombreFoto);
            $sql->bindValue(5, $nombreFirma);
            $sql->bindValue(6, $id);
            $sql->execute();

            return [
                "status" => "success",
                "message" => "Usuario editado correctamente."
            ];


        }
    }

    public function crear_usuario($usuario, $contrasena, $nombres, $apellidos, $rol, $foto, $firma, $estado)
    {

        if (empty($usuario) || empty($contrasena) || empty($nombres) || empty($apellidos) || empty($rol) || empty($estado))
            return [
                "status" => "error",
                "message" => "Verifique los campos vacios."
            ];

        $validar = "SELECT * FROM usuarios WHERE usuario = ?";
        $validar = $this->db->prepare($validar);
        $validar->bindValue(1, $usuario);
        $validar->execute();

        if ($validar->rowCount() > 0)
            return ["status" => "error", "message" => "El usuario ya existe."];

        if (empty($foto))
            $foto = 'user.jpg';
        if (empty($firma))
            $firma = 'firma.jpg';

        $sql = "INSERT INTO usuarios (usuario,contrasena,nombres,apellidos,rol,foto,firma,estado,created_at,updated_at) VALUES (?,?,?,?,?,?,?,?,now(),now())";
        $sql = $this->db->prepare($sql);

        $contrasenaEncriptada = password_hash($contrasena, PASSWORD_DEFAULT);

        $nombreFoto = uniqid() . "-" . $_FILES["foto"]['name'];
        $ruta = "../img/fotos/" . $nombreFoto;
        move_uploaded_file($_FILES["foto"]['tmp_name'], $ruta);

        $nombreFirma = uniqid() . "-" . $_FILES["firma"]['name'];
        $ruta = "../img/firmas/" . $nombreFirma;
        move_uploaded_file($_FILES["firma"]['tmp_name'], $ruta);

        $sql->bindValue(1, $usuario);
        $sql->bindValue(2, $contrasenaEncriptada);
        $sql->bindValue(3, $nombres);
        $sql->bindValue(4, $apellidos);
        $sql->bindValue(5, $rol);
        $sql->bindValue(6, $nombreFoto);
        $sql->bindValue(7, $nombreFirma);
        $sql->bindValue(8, $estado);
        $sql->execute();

        $response = [
            "status" => "success",
            "message" => "Se ha creado con exito."
        ];

        return $response;
    }
    public function editar_usuario($id, $usuario, $contrasena, $nombres, $apellidos, $rol, $foto, $firma, $estado, $archivoFoto, $archivoFirma)
    {

        if (empty($nombres) || empty($apellidos) || empty($rol) || empty($estado))
            return [
                "status" => "error",
                "message" => "Verifique los campos vacios."
            ];

        if (empty($contrasena)) {
            $sql = "UPDATE usuarios SET nombres = ?, apellidos = ?, rol = ?, foto = ?, firma = ?, estado = ?, updated_at = now() WHERE id = ?";
            $sql = $this->db->prepare($sql);

            if (empty($foto)) {
                $nombreFoto = $archivoFoto;
            } else {
                $nombreFoto = uniqid() . "-" . $_FILES["foto"]['name'];
                $ruta = "../img/fotos/" . $nombreFoto;
                move_uploaded_file($_FILES["foto"]['tmp_name'], $ruta);
            }

            if (empty($firma)) {
                $nombreFirma = $archivoFirma;
            } else {
                $nombreFirma = uniqid() . "-" . $_FILES["firma"]['name'];
                $ruta = "../img/firmas/" . $nombreFirma;
                move_uploaded_file($_FILES["firma"]['tmp_name'], $ruta);
            }

            $sql->bindValue(1, $nombres);
            $sql->bindValue(2, $apellidos);
            $sql->bindValue(3, $rol);
            $sql->bindValue(4, $nombreFoto);
            $sql->bindValue(5, $nombreFirma);
            $sql->bindValue(6, $estado);
            $sql->bindValue(7, $id);
            $sql->execute();

            return [
                "status" => "success",
                "message" => "Usuario editado correctamente."
            ];

        } else {
            $sql = "UPDATE usuarios SET contrasena = ?, nombres = ?, apellidos = ?, rol = ?, foto = ?, firma = ?, estado = ?, updated_at = now() WHERE id = ?";
            $sql = $this->db->prepare($sql);
            $contrasenaEncriptada = password_hash($contrasena, PASSWORD_DEFAULT);

            if (empty($foto)) {
                $nombreFoto = $archivoFoto;
            } else {
                $nombreFoto = uniqid() . "-" . $_FILES["foto"]['name'];
                $ruta = "../img/fotos/" . $nombreFoto;
                move_uploaded_file($_FILES["foto"]['tmp_name'], $ruta);
            }

            if (empty($firma)) {
                $nombreFirma = $archivoFirma;
            } else {
                $nombreFirma = uniqid() . "-" . $_FILES["firma"]['name'];
                $ruta = "../img/firmas/" . $nombreFirma;
                move_uploaded_file($_FILES["firma"]['tmp_name'], $ruta);
            }

            $sql->bindValue(1, $contrasenaEncriptada);
            $sql->bindValue(2, $nombres);
            $sql->bindValue(3, $apellidos);
            $sql->bindValue(4, $rol);
            $sql->bindValue(5, $nombreFoto);
            $sql->bindValue(6, $nombreFirma);
            $sql->bindValue(7, $estado);
            $sql->bindValue(8, $id);
            $sql->execute();

            return [
                "status" => "success",
                "message" => "Usuario editado correctamente."
            ];


        }
    }
    public function eliminar_usuario($id)
    {

        $sql = "UPDATE usuarios SET estado = ? WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, "eliminado");
        $sql->bindValue(2, $id);
        $sql->execute();

        return [
            "status" => "success",
            "message" => "Se ha eliminado con exito."
        ];
    }
}




