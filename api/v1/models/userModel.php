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
        
        $stmtVerify = $conectar->prepare("
            SELECT COUNT(*) as count
            FROM $table
            WHERE email = :email OR username = :username OR phone = :phone OR identification = :identification
        ");
        
        $stmtVerify->bindParam(":email", $data['email'], PDO::PARAM_STR);
        $stmtVerify->bindParam(":username", $data['username'], PDO::PARAM_STR);
        $stmtVerify->bindParam(":phone", $data['phone'], PDO::PARAM_STR);
        $stmtVerify->bindParam(":identification", $data['identification'], PDO::PARAM_STR);
        $stmtVerify->execute();
        $result = $stmtVerify->fetch(PDO::FETCH_ASSOC);
        
        if($result['count'] > 0) {
            return 'verifyFalse';
        }
        
        // Generar un token de restablecimiento de clave combinado con el email
        $password_reset_token = hash('md5', $data['email'] . bin2hex(random_bytes(32)));
        // Generar un token de confirmacion de email combinado con el email
        $email_confirmed_token = hash('md5', $data['email'] . bin2hex(random_bytes(32)));
        // Generar una api_key para el usuario combinada con el email
        $api_key = hash('md5', $data['email'] . bin2hex(random_bytes(16)));
        
        $stmt = $conectar->prepare("
           INSERT INTO
                $table (name, lastname, username, identification_type_id, identification, password_hash, password_reset_token, email, email_confirmed_token, phone, phone2, api_key, birthdate, sex, created, role_id)
           VALUES
                (:name, :lastname, :username, :identification_type_id, :identification, :password_hash, :password_reset_token, :email, :email_confirmed_token, :phone, :phone2, :api_key, :birthdate, :sex, :created, :role_id)
        ");
        
        $stmt->bindParam(":name", $data['name'], PDO::PARAM_STR);
        $stmt->bindParam(":lastname", $data['lastname'], PDO::PARAM_STR);
        $stmt->bindParam(":username", $data['username'], PDO::PARAM_STR);
        $stmt->bindParam(":identification_type_id", $data['identification_type_id'], PDO::PARAM_STR);
        $stmt->bindParam(":identification", $data['identification'], PDO::PARAM_STR);
        $stmt->bindParam(":password_hash", $data['password_hash'], PDO::PARAM_STR);
        $stmt->bindParam(":password_reset_token", $password_reset_token, PDO::PARAM_STR);
        $stmt->bindParam(":email", $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(":email_confirmed_token", $email_confirmed_token, PDO::PARAM_STR);
        $stmt->bindParam(":phone", $data['phone'], PDO::PARAM_STR);
        $stmt->bindParam(":phone2", $data['phone2'], PDO::PARAM_STR);
        $stmt->bindParam(":api_key", $api_key, PDO::PARAM_STR);
        $stmt->bindParam(":birthdate", $data['birthdate'], PDO::PARAM_STR);
        $stmt->bindParam(":sex", $data['sex'], PDO::PARAM_STR);
        $stmt->bindParam(":created", $data['created'], PDO::PARAM_STR);
        $stmt->bindParam(":role_id", $data['role_id'], PDO::PARAM_STR);
        
        if($stmt->execute()){
            return 'create';
        }else{
            return false;
        }
        
        $stmt->close();
        $stmt = null;
        
    }
}