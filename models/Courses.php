<?php 

class Courses extends Connect
{
    /*
     * Funcion para insertar/registrar cursos por medio de un formulario
     */
    public function insertCourse($name, $description = null)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        // Concatenar y formatear las credenciales para generar el token
        $token = sprintf("%s-%s-%s-%s-%s", substr(md5($name), 0, 8), substr(md5($name), 0, 4), substr(md5(uniqid()), 0, 4), substr(md5(uniqid()), 0, 4), substr(md5(uniqid()), 0, 8));
        
        $sql = "
            INSERT INTO
                courses (name, description, token, created)
            VALUES
                (?, ?, ?, now())
        ";
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $description);
        $stmt->bindValue(3, $token);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
    /*
     * Funcion para actualizar registros de cursos existentes por su ID
     */
    public function updateCourseById($id, $name, $description = null)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                courses
            SET
                name = ?, description = ?
            WHERE
                id = ?
        ";
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $description);
        $stmt->bindValue(3, $id);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
    /*
     * Funcion para traer todos los cursos registrados hasta el momento
     */
    public function getCourses()
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                *
            FROM
                courses
            WHERE
                is_active = 1
        ";
        
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
    /*
     * Funcion para eliminar totalmente registros de cursos existentes por su ID
     */
    public function deleteCourseById($id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                courses
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
     * Funcion para traer los cursos mediante el ID del curso
     */
    public function getCourseById($id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                *
            FROM
                courses
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