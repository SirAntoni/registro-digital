<?php
class Conectar
{
    protected $dbh;
    public function conexion()
    {
       
        try {

            if($_SERVER['SERVER_NAME'] == "adjust-app.com"){
                $conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=gnpufoqa_registro","gnpufoqa_registro","@nT0ny53");
            }else{
                $conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=cia_21","root","root");
            }           
           
            $conectar->query("SET NAMES 'utf8'");
           
            return $conectar;
            
        } catch (Exception $e) {

            print "¡Error!: " . $e->getMessage() . "<br/>";
           die();  
            
        }
    }
}