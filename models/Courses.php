<?php 

class Courses extends Connect
{
    /*
     * Funcion para insertar/registrar cursos por medio de un formulario
     */
    public function insertCourse($parent_id, $name, $description = null)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        // Concatenar y formatear las credenciales para generar el API key
        $token = sprintf("%s-%s-%s-%s-%s", substr(md5($name), 0, 8), substr(md5($parent_id), 0, 4), substr(md5(uniqid()), 0, 4), substr(md5(uniqid()), 0, 4), substr(md5(uniqid()), 0, 8));
        
        $sql = "
            INSERT INTO
                courses (name, description, token, created)
            VALUES
                (?, ?, ?, ?, now())
        ";
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $parent_id);
        $stmt->bindValue(3, $description);
        $stmt->bindValue(4, $token);
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
}

?>