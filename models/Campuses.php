<?php

class Campuses extends Connect
{
    /*
     * Funcion para insertar un nuevo campus.
     */
    public function insertCampus($name, $description)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sqlInsert = "
            INSERT INTO
                campuses (name, description, created, is_active) 
            VALUES (?, ?, now(), 1)
        ";
        $stmt = $conectar->prepare($sqlInsert);
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $description);
        $stmt->execute();
        
        return $conectar->lastInsertId();
    }
    
    /*
     * Funcion para actualizar un campus existente.
     */
    public function updateCampusById($id, $name, $description)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                campuses
            SET
                name = ?,
                description = ?
            WHERE
                id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $description);
        $stmt->bindValue(3, $id);
        $stmt->execute();
        
        return $stmt->fetchAll();
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
    public function deleteCampusById($id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                campuses
            SET
                is_active = 0
            WHERE
                id = ?
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return true;
    }
    
    /*
     * Funcion para obtener informacion de un campus mediante su ID.
     */
    public function getCampusById($id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                *
            FROM
                campuses
            WHERE
                id = ?
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
}

?>
