<?php 

class Courses extends Database
{
    /*
     * Función para obtener la condición adicional basada en $_SESSION['role_id']
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
    * Metodo para crear un curso por el ID e IDR
    */
    public function insertCourse($name, $description, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = '
            SELECT
                *
            FROM
                courses
            WHERE
                name = ? AND is_active != 0 AND idr = ?
        ';

        $query  = $conectar->prepare($sql);
        $query->bindValue(1, $name);
        $query->bindValue(2, $idr);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if($result){
            return false;
        }else{
            $token = sprintf("%s-%s-%s-%s-%s", substr(md5($name), 0, 8), substr(md5($name), 0, 4), substr(md5(uniqid()), 0, 4), substr(md5(uniqid()), 0, 4), substr(md5(uniqid()), 0, 8));

            $sqlInsert = "
                INSERT INTO
                    courses (name, description, token, created, idr)
                VALUES
                    (?, ?, ?, now(), ?)
            ";
            
            $stmtInsert = $conectar->prepare($sqlInsert);
            $stmtInsert->bindValue(1, $name);
            $stmtInsert->bindValue(2, $description);
            $stmtInsert->bindValue(3, $token);
            $stmtInsert->bindValue(4, $idr);
            return $stmtInsert->execute();
        }
    }
    /*
    * Metodo para actualizar un curso por el ID e IDR
    */
    public function updateCourse($id, $name, $description, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = '
            SELECT
                *
            FROM
                courses
            WHERE
                name = ? AND id != ? AND is_active != 0 AND idr = ?
        ';

        $query  = $conectar->prepare($sql);
        $query->bindValue(1, $name);
        $query->bindValue(2, $id);
        $query->bindValue(3, $idr);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if($result){
            return false;
        }else{
            $sqlUpdate = "
                UPDATE
                    courses
                SET
                    name = ?,
                    description = ?
                WHERE
                    id = ? AND idr = ?
            ";
            
            $stmtUpdate = $conectar->prepare($sqlUpdate);
            $stmtUpdate->bindValue(1, $name);
            $stmtUpdate->bindValue(2, $description);
            $stmtUpdate->bindValue(3, $id);
            $stmtUpdate->bindValue(4, $idr);
            return $stmtUpdate->execute();
        }
    }
    /*
     * Funcion para traer todos los cursos registrados hasta el momento
     */
    public function getCourses($idr)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        // Determinar la condición basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);
        
        $sql = "
            SELECT
                *
            FROM
                courses
            WHERE
                is_active = 1 ".$condition;
        
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        
        return $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /*
     * Funcion para eliminar totalmente registros de cursos existentes por su ID
     */
    public function deleteCourseById($id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        // Determinar la condición basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);
        
        $sql = "
            UPDATE
                courses
            SET
                is_active = 0
            WHERE
                id = ? ".$condition;
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        
        return $stmt->execute();
    }
    /*
     * Funcion para traer los cursos mediante el ID del curso
     */
    public function getCourseById($id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $condition = $this->getSessionCondition($idr);
        
        $sql = "
            SELECT
                *
            FROM
                courses
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
                courses
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

?>