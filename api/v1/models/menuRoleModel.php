<?php 

require_once(__DIR__ . '/../../../config/database.php');

class menuRoleModel extends Database
{
    /*=========================
     Mostrar todos los registros
     ===========================*/
    static public function index($table)
    {
        $connect = new Database();
        $conectar = $connect->connection();
        $connect->set_names();
        
        $stmt = $conectar->prepare("SELECT * FROM $table");
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }
    /*=========================
     Mostrar registro por ID
     ===========================*/
    static public function menuRoleById($table, $id)
    {
        $connect = new Database();
        $conectar = $connect->connection();
        $connect->set_names();
        
        $stmt = $conectar->prepare("SELECT * FROM $table WHERE id = ? AND is_active = 1");
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /*=========================
     Crear usuario
     ===========================*/
    static public function create($table, $data)
    {
        $connect = new Database();
        $conectar = $connect->connection();
        $connect->set_names();
        
        $success = true;
        
        foreach($data as $row){
            $stmt = $conectar->prepare("
               INSERT INTO
                    $table (menu_id, role_id, permission, idr, created)
               VALUES
                    (:menu_id, :role_id, :permission, :idr, :created)
            ");
            
            $stmt->bindParam(":menu_id", $row['menu_id'], PDO::PARAM_INT);
            $stmt->bindParam(":role_id", $row['role_id'], PDO::PARAM_INT);
            $stmt->bindParam(":permission", $row['permission'], PDO::PARAM_STR);
            $stmt->bindParam(":idr", $row['idr'], PDO::PARAM_INT);
            $stmt->bindParam(":created", $row['created'], PDO::PARAM_STR);
            
            // Ejecutar la inserción y verificar si hubo algún error
            if (!$stmt->execute()) {
                $success = false;
                break; // Si hay un error, salir del bucle
            }
        }
        $stmt = null; // Cerrar el objeto PDOStatement
        
        return $success;
    }
}