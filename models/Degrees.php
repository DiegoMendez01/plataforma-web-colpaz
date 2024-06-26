<?php

require_once (__DIR__."/../config/database.php");

class Degrees extends Database
{
    /*
     * Funcion para insertar grados por medio de un formulario
     */
    public function createDegree($name)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = '
            SELECT
                *
            FROM
                degrees
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
                    degrees (name, created)
                VALUES
                    (?, now())
            ";
            
            $stmtInsert = $conectar->prepare($sqlInsert);
            $stmtInsert->bindValue(1, $name);
            return $stmtInsert->execute();
        }
    }
    /*
     * Funcion para actualizar grados por medio de un formulario
     */
    public function updateDegree($id, $name)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = '
            SELECT
                *
            FROM
                degrees
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
                    degrees
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
     * Funcion para traer todos los grados registrados hasta el momento
     */
    public function getDegrees()
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                *
            FROM
                degrees
            WHERE
                is_active = 1
        ";
        
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        
        return $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /*
     * Función para traer todas los grados asociados a un aula academica específica
     */
    public function getDegreesByClassroom($classroom_id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
        SELECT
            d.*
        FROM
            degrees AS d
        INNER JOIN
            classrooms AS c ON d.id = c.degree_id
        WHERE
            c.is_active = 1 AND c.id = ?
    ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $classroom_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /*
     * Funcion para eliminar totalmente registros de grados existentes por su ID
     */
    public function deleteDegreeById($id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                degrees
            SET
                is_active = 0
            WHERE
                id = ?
        ";
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
    /*
     * Funcion para traer los grados mediante el ID del grado
     */
    public function getDegreeById($id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                *
            FROM
                degrees
            WHERE
                id = ?
        ";
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
