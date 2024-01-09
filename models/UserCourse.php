<?php

class UserCourses extends Connect
{
    /*
     * Funcion para inscribir a un usuario en un curso mediante un formulario
     */
    public function enrollUserInCourse($user_id, $course_id)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            INSERT INTO
                user_courses (user_id, course_id, enrolled_at, is_active) 
            VALUES (?, ?, now(), 1)
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $user_id);
        $stmt->bindValue(2, $course_id);
        $stmt->execute();

        return $conectar->lastInsertId();
    }

    /*
     * Funcion para obtener todos los cursos en los que un usuario esta inscrito
     */
    public function getCoursesByUserId($user_id)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            SELECT
                uc.*, c.course_name
            FROM 
                user_courses uc
            INNER JOIN
                courses c ON uc.course_id = c.id
            WHERE
                uc.user_id = ? AND uc.is_active = 1
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $user_id);
        $stmt->execute();

        return $result = $stmt->fetchAll();
    }

    /*
     * Funcion para desinscribir a un usuario de un curso (eliminado logico)
     */
    public function unenrollUserFromCourse($user_course_id)
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
