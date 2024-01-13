<?php

class UserCourses extends Connect
{
    /*
     * Funcion para inscribir a un usuario en un curso mediante un formulario
     */
    public function insertUserCourse($user_id, $course_id)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            INSERT INTO
                user_courses (user_id, course_id, created, is_active) 
            VALUES (?, ?, now(), 1)
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $user_id);
        $stmt->bindValue(2, $course_id);
        $stmt->execute();

        return $conectar->lastInsertId();
    }
    /*
     * Funcion para actualizar registros de asignaciones de usuarios por cursos
     */
    public function updateUserCourse($id, $user_id, $course_id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                user_courses
            SET
                user_id   = ?,
                course_id = ?
            WHERE
                id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $user_id);
        $stmt->bindValue(2, $course_id);
        $stmt->bindValue(3, $id);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    /*
     * Funcion para obtener los cursos mediante un formulario
     */
    public function getUsers()
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                * 
            FROM 
                users
            WHERE
                is_active = 1
        ";
        
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        
        return $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /*
     * Funcion para obtener los usuarios mediante un formulario
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
        
        return $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /*
     * Funcion para obtener todos los cursos en los que un usuario esta inscrito
     */
    public function getUserCourses()
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                * 
            FROM 
                user_courses
            WHERE
                is_active = 1
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
    
    /*
     * Funcion para desinscribir a un usuario de un curso (eliminado logico)
     */
    public function deleteUserCourseById($user_course_id)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            UPDATE
                user_courses
            SET
                is_active = 0
            WHERE
                id = ?
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $user_course_id);
        $stmt->execute();

        return true;
    }

    /*
     * Funcion para obtener informacion de la inscripcion de un usuario en un curso mediante el ID de inscripcion
     */
    public function getUserCourseById($user_course_id)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            SELECT
                *
            FROM
                user_courses
            WHERE
                id = ?
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $user_course_id);
        $stmt->execute();

        return $result = $stmt->fetchAll();
    }
}
