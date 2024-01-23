<?php

class StudentTeachers extends Connect
{
    /*
     * Funcion para inscribir a un estudiante en un curso mediante un formulario
     */
    public function insertStudentTeacher($user_id, $teacher_course_id, $period_id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        // Consulta para insertar
        $sql = '
            SELECT
                *
            FROM
                student_teachers
            WHERE
                user_id = ? AND teacher_course_id = ? AND period_id = ? AND is_active != 0
        ';
        
        $query  = $conectar->prepare($sql);
        $query->bindValue(1, $user_id);
        $query->bindValue(2, $teacher_course_id);
        $query->bindValue(3, $period_id);
        $query->execute();
        $resultInsert = $query->fetch(PDO::FETCH_ASSOC);
        
        if($resultInsert > 0){
            $answer = [
                'status' => false,
                'msg'    => 'El grado, profesor materia y periodo existen, seleccione otro'
            ];
            echo json_encode($answer, JSON_UNESCAPED_UNICODE);
        }else{
            $sqlInsert = "
                INSERT INTO
                    student_teachers (user_id, teacher_course_id, period_id, created, is_active) 
                VALUES (?, ?, ?, now(), 1)
            ";
            $stmt = $conectar->prepare($sqlInsert);
            $stmt->bindValue(1, $user_id);
            $stmt->bindValue(2, $teacher_course_id);
            $stmt->bindValue(3, $period_id);
            $stmt->execute();
            
            return $conectar->lastInsertId();
        }
    }
    /*
     * Funcion para actualizar registros de asignaciones de estudiantes por cursos
     */
    public function updateStudentTeacher($id, $user_id, $teacher_course_id, $period_id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                student_teachers
            SET
                user_id   = ?,
                teacher_course_id = ?,
                period_id = ?
            WHERE
                id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $user_id);
        $stmt->bindValue(2, $teacher_course_id);
        $stmt->bindValue(3, $period_id);
        $stmt->bindValue(4, $id);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    /*
     * Funcion para obtener todos los cursos en los que un usuario esta inscrito
     */
    public function getStudentTeacher()
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                * 
            FROM 
                student_teachers
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
    public function deleteStudentTeacherById($id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                student_teachers
            SET
                is_active = 0
            WHERE
                id = ?
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return true;
    }
    /*
     * Funcion para obtener informacion de la inscripcion de un usuario en un curso mediante el ID de inscripcion
     */
    public function getStudentTeacherById($id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                *
            FROM
                student_teachers
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
