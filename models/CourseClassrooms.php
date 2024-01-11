<?php

class CourseClassrooms extends Connect
{
    /*
     * Funcion para insertar/registrar asignaciones de aulas a cursos por medio de un formulario
     */
    public function insertClassrooms($course_id, $classroom_id)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            INSERT INTO
                course_classrooms (course_id, classroom_id, assigned_at, is_active) 
            VALUES (?, ?, now(), 1)
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $course_id);
        $stmt->bindValue(2, $classroom_id);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /*
     * Funcion para obtener todas las asignaciones de aulas a cursos registradas hasta el momento
     */
    public function getCourseClassrooms($course_id)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            SELECT
                * 
            FROM 
                course_classrooms
            WHERE
                course_id = ? AND is_active = 1
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $course_id);
        $stmt->execute();

        return $result = $stmt->fetchAll();
    }

    /*
     * Funcion para actualizar registros de asignaciones de aulas a cursos
     */
    public function updateCourseClassrooms($id, $course_id, $classroom_id)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            UPDATE
                course_classrooms
            SET
                course_id = ?,
                classroom_id = ?
            WHERE
                id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $course_id);
        $stmt->bindValue(2, $classroom_id);
        $stmt->bindValue(3, $id);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /*
     * Funcion para eliminar totalmente registros de asignaciones de aulas a cursos (eliminado logico)
     */
    public function deleteCourseClassroomsById($id)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            UPDATE
                course_classrooms
            SET
                is_active = 0
            WHERE
                id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /*
     * Funcion para obtener información de la asignación de un aula a un curso mediante el ID de la asignacion
     */
    public function getCourseClassroomById($id)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            SELECT
                *
            FROM
                course_classrooms
            WHERE
                id = ?
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();

        return $result = $stmt->fetchAll();
    }
}
