<?php

class Classrooms extends Connect
{
    /*
     * Funcion para insertar/registrar grados academicos por medio de un formulario
     */
    public function insertClassroom($name)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            INSERT INTO
                classrooms (name, created) 
            VALUES (?, now())
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $name);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
    /*
     * Funcion para traer todos los grados academicos registrados hasta el momento
     */
    public function getClassrooms()
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                * 
            FROM 
                classrooms
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
    public function updateClassroom($id, $name)
    {
        $conectar = parent::connection();
        parent::set_names();
    
        $sql = "
            UPDATE
                classrooms
            SET
                name = ?
            WHERE
                id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $id);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
    /*
     * Funcion para eliminar totalmente registros de grados existentes (eliminado logico)
     */
    public function deleteClassroomById($id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                classrooms
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
     * Funcion para traer los usuarios mediante el ID del usuario
     */
    public function getClassroomById($id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                *
            FROM
                classrooms
            WHERE
                id = ?
        ";
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
}