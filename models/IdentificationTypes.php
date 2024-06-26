<?php

require_once (__DIR__."/../config/database.php");

class IdentificationTypes extends Database
{
    /*
     * Funcion para insertar tipos de identificaciones por medio de un formulario
     */
    public function insertIdentificationType($name)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = '
            SELECT
                *
            FROM
                identification_types
            WHERE
                name = ? AND is_active != 0
        ';
        
        $query  = $conectar->prepare($sql);
        $query->bindValue(1, $name);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        if($result){
            return false;
        }else{
            $sqlInsert = "
                INSERT INTO
                    identification_types (name, created)
                VALUES
                    (?, now())
            ";
            
            $stmtInsert = $conectar->prepare($sqlInsert);
            $stmtInsert->bindValue(1, $name);
            return $stmtInsert->execute();
        }
    }
    /*
     * Funcion para actualizar tipos de identificaciones por medio de un formulario
     */
    public function updateIdentificationType($id, $name)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = '
            SELECT
                *
            FROM
                identification_types
            WHERE
                name = ? AND id != ? AND is_active != 0
        ';
        
        $query  = $conectar->prepare($sql);
        $query->bindValue(1, $name);
        $query->bindValue(2, $id);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        if($result){
            return false;
        }else{
            $sqlUpdate = "
                UPDATE
                    identification_types
                SET
                    name      = ?
                WHERE
                    id = ?
            ";
            
            $stmtUpdate = $conectar->prepare($sqlUpdate);
            $stmtUpdate->bindValue(1, $name);
            $stmtUpdate->bindValue(2, $id);
            return $stmtUpdate->execute();
        }
    }
    /*
     * Funcion para obtener todos los tipos de identificacion
     */
    public function getIdentificationTypes()
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            SELECT
                *
            FROM 
                identification_types
            WHERE
                is_active = 1
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();

        return $result = $stmt->fetchAll();
    }
    /*
     * Funcion para eliminar totalmente registros de tipo de identificaciones existentes (eliminado logico)
     */
    public function deleteIdentificationTypeById($id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                identification_types
            SET
                is_active = 0
            WHERE
                id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
    /*
     * Funcion para traer un tipo de identificacion segun el ID
     */
    public function getIdentificationTypeById($id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                *
            FROM
                identification_types
            WHERE
                id = ? AND is_active = 1
        ";
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>