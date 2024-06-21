<?php

class Campuses extends Database
{
    /*
     * Funcion para insertar una sede.
     */
    public function createCampuse($name, $description)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = '
            SELECT
                *
            FROM
                campuses
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
                    campuses (name, description, created)
                VALUES
                    (?, ?, now())
            ";
            
            $stmtInsert = $conectar->prepare($sqlInsert);
            $stmtInsert->bindValue(1, $name);
            $stmtInsert->bindValue(2, $description);
            return $stmtInsert->execute();
        }
    }
    /*
    * Funcion para actualizar una sede
    */
    public function updateCampuse($idr, $name, $description)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = '
            SELECT
                *
            FROM
                campuses
            WHERE
                name = ? AND idr != ? AND is_active != 0
        ';
        
        $query  = $conectar->prepare($sql);
        $query->bindValue(1, $name);
        $query->bindValue(2, $idr);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        if($result){
            return false;
        }else{
            $sqlUpdate = "
                UPDATE
                    campuses
                SET
                    name        = ?,
                    description = ?
                WHERE
                    idr = ?
            ";
            
            $stmtUpdate = $conectar->prepare($sqlUpdate);
            $stmtUpdate->bindValue(1, $name);
            $stmtUpdate->bindValue(2, $description);
            $stmtUpdate->bindValue(3, $idr);
            return $stmtUpdate->execute();
        }
    }
    /*
     * Funcion para obtener todos los campus activos.
     */
    public function getCampuses()
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                * 
            FROM 
                campuses
            WHERE
                is_active = 1
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
    /*
     * Funcion para eliminar un campus (eliminado logico).
     */
    public function deleteCampuseById($idr)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                campuses
            SET
                is_active = 0
            WHERE
                idr = ?
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $idr);
        $stmt->execute();
        
        return true;
    }
    /*
     * Funcion para obtener informacion de un campus mediante su ID.
     */
    public function getCampuseById($idr)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                *
            FROM
                campuses
            WHERE
                idr = ?
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $idr);
        $stmt->execute();
        
        return $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>
