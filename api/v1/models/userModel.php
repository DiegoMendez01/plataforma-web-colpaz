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
    /*=========================
     Mostrar registro por ID
     ===========================*/
    static public function userById($table, $id)
    {
        $connect = new Connect();
        $conectar = $connect->connection();
        $connect->set_names();
        
        $stmt = $conectar->prepare("SELECT * FROM $table WHERE id = ? AND is_active = 1");
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
        
        $stmt->close();
        $stmt = null;
        
    }
}