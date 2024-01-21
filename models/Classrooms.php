<?php

class Classrooms extends Connect
{
    /*
     * Funcion para insertar/registrar aulas academicas por medio de un formulario
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
     * Funcion para traer todos las aulas academicas registrados hasta el momento
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
     * Funcion para actualizar registros de aulas academicas
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
     * Funcion para eliminar totalmente registros de aulas academicas existentes (eliminado logico)
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
     * Funcion para traer un aula academica segun el ID
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