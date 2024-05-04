<?php
class Registros extends Conectar
{

    private $db;

    public function __construct()
    {
        $this->db = Conectar::conexion();
    }

    public function listar_registros($id, $rol)
    {
        if ($rol === '3') {
            $sql = "SELECT * FROM registros WHERE firma_gdh = ? AND usuario_id = ?";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1,1);
            $sql->bindValue(2,$id);
        }else{
            $sql = "SELECT * FROM registros";
            $sql = $this->db->prepare($sql);
        }
       
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear_registro($usuario, $promotor, $tipo, $indicativo, $clasificacion, $recibido, $asunto)
    {
        if (empty($usuario) || empty($promotor) || empty($tipo) || empty($indicativo) || empty($clasificacion) || empty($recibido) || empty($asunto))
            return [
                "status" => "error",
                "message" => "Verifique los campos vacios."
            ];

        $sql = "INSERT INTO registros (usuario_id,promotor,tipo,indicativo,fecha,clasificacion,asunto,recibido,updated_at) VALUES(?,?,?,?,now(),?,?,?,now())";

        $sql = $this->db->prepare($sql);

        $sql->bindValue(1, $usuario);
        $sql->bindValue(2, $promotor);
        $sql->bindValue(3, $tipo);
        $sql->bindValue(4, $indicativo);
        $sql->bindValue(5, $clasificacion);
        $sql->bindValue(6, $asunto);
        $sql->bindValue(7, $recibido);

        $sql->execute();

        return [
            "status" => "success",
            "message" => "Se ha creado con exito."
        ];

    }

    public function firmar($id,$usuario){

        $sql = "UPDATE registros SET firma_gdh = ?, firma_gdh_fecha = now(), firma_gdh_usuario = ? WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1,1);
        $sql->bindValue(2,$usuario);
        $sql->bindValue(3,$id);

        $sql->execute();

        return [
            "status" => "success",
            "message" => "Documento firmado con exito"
        ];

    }

    public function firmar_destino($id,$usuario){

        $sql = "UPDATE registros SET firma_destino = ?, firma_destino_fecha = now() WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1,1);
        $sql->bindValue(2,$id);

        $sql->execute();

        return [
            "status" => "success",
            "message" => "Documento firmado con exito"
        ];

    }
}




