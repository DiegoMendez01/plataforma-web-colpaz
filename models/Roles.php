<?php

require_once (__DIR__."/../config/database.php");

class Roles extends Database
{
    /*
     * Función para obtener la condición adicional basada en $_SESSION['role_id']
     */
    private function getSessionCondition($idr, $view = null)
    {
        if ($_SESSION['role_id'] == 1) {
            if(!empty($view)){
                return 'AND idr = '.$idr;
            }else{
                return ''; // Sin condición adicional si role_id es 1
            }
        } else {
            return 'AND id <> 1 AND (idr = '.$idr.' OR id IN (2, 3, 4, 5))';
        }
    }
    /*
     * Funcion para insertar un rol
     */
    public function insertRole($name, $functions, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = '
            SELECT
                *
            FROM
                roles
            WHERE
                name = ? AND functions = ? AND is_active != 0 AND idr = ?
        ';
        
        $query  = $conectar->prepare($sql);
        $query->bindValue(1, $name);
        $query->bindValue(2, $functions);
        $query->bindValue(3, $idr);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        if($result){
            return false;
        }else{
            $sqlInsert = "
                INSERT INTO
                    roles (name, functions, created, idr)
                VALUES
                    (?, ?, now(), ?)
            ";
            
            $stmtInsert = $conectar->prepare($sqlInsert);
            $stmtInsert->bindValue(1, $name);
            $stmtInsert->bindValue(2, $functions);
            $stmtInsert->bindValue(3, $idr);
            return $stmtInsert->execute();
        }
    }
    /*
     * Funcion para actualizar un rol
     */
    public function updateRole($id, $name, $functions, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = '
            SELECT
                *
            FROM
                roles
            WHERE
                name = ? AND functions = ? AND id != ? AND is_active != 0 AND idr = ?
        ';
        
        $query  = $conectar->prepare($sql);
        $query->bindValue(1, $name);
        $query->bindValue(2, $functions);
        $query->bindValue(3, $id);
        $query->bindValue(4, $idr);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        if($result){
            return false;
        }else{
            $sqlUpdate = "
                UPDATE
                    roles
                SET
                    name      = ?,
                    functions = ?
                WHERE
                    id = ?
            ";
            
            $stmtUpdate = $conectar->prepare($sqlUpdate);
            $stmtUpdate->bindValue(1, $name);
            $stmtUpdate->bindValue(2, $functions);
            $stmtUpdate->bindValue(3, $id);
            return $stmtUpdate->execute();
        }
    }
    /*
     * Funcion para obtener todos los roles
     */
    public function getRoles($idr)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        // Determinar la condición basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);
        
        $sql = "
            SELECT
                *
            FROM 
                roles
            WHERE
                is_active = 1 AND id <> 1 ".$condition;
        
        $stmt = $conectar->prepare($sql);
        $stmt->execute();

        return $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
     * Funcion para obtener informacion de un rol por su ID
     */
    public function getRolesById($id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        // Determinar la condición basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);
        
        $sql = "
            SELECT
                *
            FROM
                roles
            WHERE
                id = ? AND is_active = 1 ".$condition;
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();

        return $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    /*
     * Funcion para eliminar logicamente un rol
     */
    public function deleteRolesById($id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        // Determinar la condición basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);
        
        $sql = "
            UPDATE
                roles
            SET
                is_active = 0
            WHERE
                id = ? ".$condition;
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /*
     *  Funcion para actualizar la sede del rol
     */
    public function updateAssignedCampus($id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                roles
            SET
                idr = ?
            WHERE
                id = ?
        ";
        $sql    = $conectar->prepare($sql);
        $sql->bindValue(1, $idr);
        $sql->bindValue(2, $id);
        return $sql->execute();
    }
}

