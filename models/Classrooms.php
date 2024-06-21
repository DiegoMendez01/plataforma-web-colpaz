<?php

class Classrooms extends Database
{
    /*
     * Funcion para obtener la condicion adicional basada en $_SESSION['role_id']
     */
    private function getSessionCondition($idr)
    {
        if ($_SESSION['role_id'] == 1) {
            return '';
        } else {
            return 'AND idr = '.$idr;
        }
    }
    /*
     * Funcion para insertar aulas academicas por medio de un formulario
     */
    public function createClassroom($name, $degree_id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = '
            SELECT
                *
            FROM
                classrooms
            WHERE
                name = ? AND degree_id = ? AND is_active != 0 AND idr = ?
        ';
        
        $query  = $conectar->prepare($sql);
        $query->bindValue(1, $name);
        $query->bindValue(2, $degree_id);
        $query->bindValue(3, $idr);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result){
            return false;
        }else{
            $sqlInsert = "
                INSERT INTO
                    classrooms (name, degree_id, idr, created)
                VALUES
                    (?, ?, ?, now())
            ";
            
            $stmtInsert = $conectar->prepare($sqlInsert);
            $stmtInsert->bindValue(1, $name);
            $stmtInsert->bindValue(2, $degree_id);
            $stmtInsert->bindValue(3, $idr);
            return $stmtInsert->execute();
        }
    }
    /*
     * Funcion para actualizar aulas academicas por medio de un formulario
     */
    public function updateClassroom($id, $name, $degree_id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = '
            SELECT
                *
            FROM
                classrooms
            WHERE
                name = ? AND degree_id = ? AND id != ? AND is_active != 0 AND idr = ?
        ';
        
        $query  = $conectar->prepare($sql);
        $query->bindValue(1, $name);
        $query->bindValue(2, $degree_id);
        $query->bindValue(3, $id);
        $query->bindValue(4, $idr);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result){
            return false;
        }else{
            $sqlUpdate = "
                UPDATE
                    classrooms
                SET
                    name      = ?,
                    degree_id = ?,
                    idr = ?
                WHERE
                    id = ?
            ";
            
            $stmtUpdate = $conectar->prepare($sqlUpdate);
            $stmtUpdate->bindValue(1, $name);
            $stmtUpdate->bindValue(2, $degree_id);
            $stmtUpdate->bindValue(3, $idr);
            $stmtUpdate->bindValue(4, $id);
            return $stmtUpdate->execute();
        }
    }
    /*
     * Funcion para traer todos las aulas academicas registrados hasta el momento
     */
    public function getClassrooms($idr)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        // Determinar la condición basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);

        $sql = "
            SELECT
                * 
            FROM 
                classrooms
            WHERE
                is_active = 1 ".$condition;
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        
        return $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /*
     * Función para traer todas las aulas academicas asociadas a un grado específico
     */
    public function getClassroomsByDegree($degree_id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        // Determinar la condición basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);
        
        $sql = "
            SELECT
                c.*
            FROM
                classrooms AS c
            INNER JOIN degrees AS d ON c.degree_id = d.id
            WHERE
                c.is_active = 1 AND c.degree_id = ? ".$condition;
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $degree_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /*
     * Funcion para eliminar totalmente registros de aulas academicas existentes (eliminado logico)
     */
    public function deleteClassroomById($id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        // Determinar la condición basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);
        
        $sql = "
            UPDATE
                classrooms
            SET
                is_active = 0
            WHERE
                id = ?".$condition;
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        
        return $stmt->execute();
    }
    /*
     * Funcion para traer un aula academica segun el ID
     */
    public function getClassroomById($id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        // Determinar la condición basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);
        
        $sql = "
            SELECT
                *
            FROM
                classrooms
            WHERE
                id = ? ".$condition;
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /*
     *  Funcion para actualizar la sede
     */
    public function updateAssignedCampus($id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                classrooms
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