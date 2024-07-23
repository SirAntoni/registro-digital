<?php
class Registros extends Conectar
{

    private $db;

    public function __construct()
    {
        $this->db = Conectar::conexion();
    }

    private function encryptFile($source, $destination, $key) {
        $cipher = "aes-256-cbc";
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
    
        $input = file_get_contents($source);
        $encrypted = openssl_encrypt($input, $cipher, $key, 0, $iv);
    
        $result = $iv . $encrypted;
        file_put_contents($destination, $result);
    }

    private function decryptFile($source, $destination, $key) {
        $cipher = "aes-256-cbc";
        $ivLength = openssl_cipher_iv_length($cipher);
    
        $data = file_get_contents($source);
        $iv = substr($data, 0, $ivLength);
        $encryptedData = substr($data, $ivLength);
    
        $decrypted = openssl_decrypt($encryptedData, $cipher, $key, 0, $iv);
        file_put_contents($destination, $decrypted);
    }

    public function listar_registros($id, $rol)
    {

        if ($rol === '3') {
            $sql = "SELECT * FROM registros WHERE firma_gdh = ? AND usuario_id = ?";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, 1);
            $sql->bindValue(2, $id);
        } elseif($rol === '2') {
            $sql = "SELECT * FROM registros WHERE create_user_id = ?";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, $id);
        }else {
            $sql = "SELECT * FROM registros";
            $sql = $this->db->prepare($sql);
        }

        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener_registro($id)
    {

        $sql = "SELECT * FROM registros WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public function crear_registro($usuario_id,$documento, $promotor, $tipo, $indicativo, $clasificacion, $recibido, $asunto)
    {

        if (empty($documento) || empty($promotor) || empty($tipo) || empty($indicativo) || empty($clasificacion) || empty($recibido) || empty($asunto))
            return [
                "status" => "error",
                "message" => "Verifique los campos vacios."
            ];

        $sql = "INSERT INTO registros (documento,promotor,tipo,indicativo,fecha,clasificacion,asunto,recibido,updated_at,create_user_id) VALUES(?,?,?,?,now(),?,?,?,now(),?)";

        $key = "12345678901234567890123456789012";
        $source = $_FILES["documento"]['tmp_name'];
        $nombreDocumento = uniqid() . "-" . $_FILES["documento"]['name'];
        $destination = "../pdf/documentos/" . $nombreDocumento;
        $this->encryptFile($source, $destination, $key);

        $sql = $this->db->prepare($sql);

        $sql->bindValue(1, $nombreDocumento);
        $sql->bindValue(2, $promotor);
        $sql->bindValue(3, $tipo);
        $sql->bindValue(4, $indicativo);
        $sql->bindValue(5, $clasificacion);
        $sql->bindValue(6, $asunto);
        $sql->bindValue(7, $recibido);
        $sql->bindValue(8, $usuario_id);

        $sql->execute();

        return [
            "status" => "success",
            "message" => "Se ha creado con exito."
        ];

    }

    public function firmar($id, $firma_gdh_usuario, $usuario_id, $decreto, $observacion)
    {

        $sql = "UPDATE registros SET usuario_id = ?, decreto = ?, obs_admin = ?, firma_gdh = ?, firma_gdh_fecha = now(), firma_gdh_usuario = ? WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $usuario_id);
        $sql->bindValue(2, $decreto);
        $sql->bindValue(3, $observacion);
        $sql->bindValue(4, 1);
        $sql->bindValue(5, $firma_gdh_usuario);
        $sql->bindValue(6, $id);

        $sql->execute();

        return [
            "status" => "success",
            "message" => "Documento decretado con exito"
        ];

    }

    public function firmar_destino($id, $observacion)
    {

        $sql = "UPDATE registros SET firma_destino = ?, firma_destino_fecha = now(), obs_validador = ? WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, 1);
        $sql->bindValue(2, $observacion);
        $sql->bindValue(3, $id);

        $sql->execute();

        return [
            "status" => "success",
            "message" => "Documento firmado con exito"
        ];

    }

    public function obtener_documento($id)
    {
        $sql = "SELECT documento FROM registros WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();
        $data = $sql->fetch(PDO::FETCH_ASSOC);
        $key = "12345678901234567890123456789012";
        $source = "../pdf/documentos/" . $data['documento'];
        $destination = "../pdf/documentos/decrypted-" . $data['documento'];

        $this->decryptFile($source,$destination,$key);

        $response = [
            "status" => "success",
            "message" => "Documento obtenido con exito",
            "nameDocument" => "decrypted-" . $data['documento'],
            "destination" => $destination
        ];

        return $response;

    }

    public function restore($destination){
        unlink($destination);
    }

    public function eliminar_registro($rol,$id)
    {

        if($rol !== '1'){
            return [
                "status" => "error",
                "message" => "No tienes permisos para eliminar."
            ];
        }
            
        $sql = "DELETE FROM registros WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();

        return [
            "status" => "success",
            "message" => "Se ha eliminado con exito."
        ];
    }
}




