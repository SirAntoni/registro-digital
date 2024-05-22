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

    public function crear_registro($documento, $promotor, $tipo, $indicativo, $clasificacion, $recibido, $asunto)
    {

        if (empty($documento) || empty($promotor) || empty($tipo) || empty($indicativo) || empty($clasificacion) || empty($recibido) || empty($asunto))
            return [
                "status" => "error",
                "message" => "Verifique los campos vacios."
            ];

        $sql = "INSERT INTO registros (documento,promotor,tipo,indicativo,fecha,clasificacion,asunto,recibido,updated_at) VALUES(?,?,?,?,now(),?,?,?,now())";


        $nombreDocumento = uniqid() . "-" . $_FILES["documento"]['name'];
        $ruta = "../pdf/documentos/" . $nombreDocumento;
        move_uploaded_file($_FILES["documento"]['tmp_name'], $ruta);

        $sql = $this->db->prepare($sql);

        $sql->bindValue(1, $nombreDocumento);
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

    public function firmar($id,$firma_gdh_usuario,$usuario_id,$decreto,$observacion){

        $sql = "UPDATE registros SET usuario_id = ?, decreto = ?, obs_admin = ?, firma_gdh = ?, firma_gdh_fecha = now(), firma_gdh_usuario = ? WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1,$usuario_id);
        $sql->bindValue(2,$decreto);
        $sql->bindValue(3,$observacion);
        $sql->bindValue(4,1);
        $sql->bindValue(5,$firma_gdh_usuario);
        $sql->bindValue(6,$id);

        $sql->execute();

        return [
            "status" => "success",
            "message" => "Documento decretado con exito"
        ];

    }

    public function firmar_destino($id,$observacion){

        $sql = "UPDATE registros SET firma_destino = ?, firma_destino_fecha = now(), obs_validador = ? WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1,1);
        $sql->bindValue(2,$observacion);
        $sql->bindValue(3,$id);

        $sql->execute();

        return [
            "status" => "success",
            "message" => "Documento firmado con exito"
        ];

    }
}




