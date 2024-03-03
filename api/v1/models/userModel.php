<?php 

require_once(__DIR__ . '/../../../config/connection.php');

class userModel extends Connect
{
    /*=========================
     Mostrar todos los registros
     ===========================*/
    static public function index($table)
    {
        $connect = new Connect();
        $conectar = $connect->connection();
        $connect->set_names();
        
        $stmt = $conectar->prepare("SELECT * FROM $table");
        $stmt->execute();
        
        return $stmt->fetchAll();
        
        $stmt->close();
        $stmt = null;
        
    }
}