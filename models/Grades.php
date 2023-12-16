<?php

class Grades extends Connect
{
    /*
     * Funcion para insertar/registrar grados academicos por medio de un formulario
     */
    public function insertGrade($name)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            INSERT INTO
                grades (nombre, descripcion, created) 
            VALUES (?, ?, now())
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $name);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
    /*
     * Funcion para traer todos los grados academicos registrados hasta el momento
     */
    public function getGrades()
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                * 
            FROM 
                grades
            WHERE
                is_active = 1
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
    /*
     * Funcion para actualizar registros de grados academicos
     */
    public function updateGrade($id, $name)
    {
        $conectar = parent::connection();
        parent::set_names();
    
        $sql = "
            UPDATE
                grades
            SET
                nombre = ?
            WHERE
                id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $name);
        $stmt->bindValue(3, $id);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
    /*
     * Funcion para eliminar totalmente registros de grados existentes (eliminado logico)
     */
    public function deleteGradeById($id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                grades
            SET
                is_active = 0
            WHERE
                id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
}