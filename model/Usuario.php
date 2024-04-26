<?php 

class Usuarios extends Conectar{

    private $db;

    public function __construct(){
        $this->db = Conectar::conexion();
    }

    public function listar_usuarios(){

        $sql = "SELECT * FROM usuarios";
        $sql = $this->db->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);

    }
    public function crear_usuario($usuario,$contrasena,$nombres,$apellidos,$rol,$foto,$firma){

        $sql = "INSERT INTO usuarios (usuario,contrasena,nombres,apellidos,rol,foto,firma,created_at,updated_at) VALUES (?,?,?,?,?,?,?,now(),now())";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1,$usuario);
        $sql->bindValue(2,$contrasena);
        $sql->bindValue(3,$nombres);
        $sql->bindValue(4,$apellidos);
        $sql->bindValue(5,$rol);
        $sql->bindValue(6,$foto);
        $sql->bindValue(7,$firma);
        $sql->execute();

        $response = [
            "status" => "success",
            "message" => "Se ha creado con exito."
        ];

        return $response;
    }
}




