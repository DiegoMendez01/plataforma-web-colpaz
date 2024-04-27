<?php 

require_once(__DIR__ . '/../../../config/connection.php');

class menuRoleModel extends Connect
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
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
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
    /*=========================
     Crear usuario
     ===========================*/
    static public function create($table, $data)
    {
        $connect = new Connect();
        $conectar = $connect->connection();
        $connect->set_names();
        
        $stmt = $conectar->prepare("
           INSERT INTO
                $table (name, lastname, username, identification_type_id, identification, password_hash, password_reset_token, email, email_confirmed_token, phone, phone2, api_key, birthdate, sex, created, role_id)
           VALUES
                (:name, :lastname, :username, :identification_type_id, :identification, :password_hash, :password_reset_token, :email, :email_confirmed_token, :phone, :phone2, :api_key, :birthdate, :sex, :created, :role_id)
        ");
        
        return $stmt->execute();
        
        $stmt->close();
        $stmt = null;
    }
}