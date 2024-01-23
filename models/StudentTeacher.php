<?php

class StudentTeacher extends Connect
{
    /*
     * Funcion para inscribir a un estudiante en un curso mediante un formulario
     */
    public function insertStudentCourse($user_id, $course_id, $classroom_id, $period_id, $degree_id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        // Consulta para insertar
        $sql = '
            SELECT
                *
            FROM
                student_teacher
            WHERE
                user_id = ? AND course_id = ? AND classroom_id = ? AND period_id = ? AND degree_id = ? AND is_active != 0
        ';
        
        $query  = $conectar->prepare($sql);
        $query->bindValue(1, $user_id);
        $query->bindValue(2, $course_id);
        $query->bindValue(3, $classroom_id);
        $query->bindValue(4, $period_id);
        $query->bindValue(5, $degree_id);
        $query->execute();
        $resultInsert = $query->fetch(PDO::FETCH_ASSOC);
        
        if($resultInsert > 0){
            $answer = [
                'status' => false,
                'msg'    => 'El grado, curso, materia y profesor/estudiante existen, seleccione otro'
            ];
            echo json_encode($answer, JSON_UNESCAPED_UNICODE);
        }else{
            $sqlInsert = "
                INSERT INTO
                    student_teacher (user_id, course_id, classroom_id, period_id, degree_id, created, is_active) 
                VALUES (?, ?, ?, ?, ?, now(), 1)
            ";
            $stmt = $conectar->prepare($sqlInsert);
            $stmt->bindValue(1, $user_id);
            $stmt->bindValue(2, $course_id);
            $stmt->bindValue(3, $classroom_id);
            $stmt->bindValue(4, $period_id);
            $stmt->bindValue(5, $degree_id);
            $stmt->execute();
            
            return $conectar->lastInsertId();
        }
    }
    /*
     * Funcion para actualizar registros de asignaciones de estudiantes por cursos
     */
    public function updateStudentCourse($id, $user_id, $course_id, $classroom_id, $period_id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                student_teacher
            SET
                user_id   = ?,
                course_id = ?,
                classroom_id = ?,
                period_id = ?
            WHERE
                id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $user_id);
        $stmt->bindValue(2, $course_id);
        $stmt->bindValue(3, $classroom_id);
        $stmt->bindValue(4, $period_id);
        $stmt->bindValue(5, $id);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    /*
     * Funcion para obtener todos los cursos en los que un usuario esta inscrito
     */
    public function getStudTeacher()
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                * 
            FROM 
                student_teacher
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
                student_teacher
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
    public function getStudentTheacherById($id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                *
            FROM
                student_teacher
            WHERE
                id = ?
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
    /*
     * Funcion para obtener los usuarios por curso, si es rol estudiante
     */
    public function getStudentTeacherByIdUser($id_user)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = '
            SELECT
                st.id,
                u.name as nameUser,
                c.name as nameCourse,
                cs.name as nameClassroom,
                d.name as nameDegree,
                p.name as namePeriod
            FROM
                student_teacher as st
            INNER JOIN users u ON st.user_id = u.id
            INNER JOIN courses c ON st.course_id = c.id
            INNER JOIN degrees d ON st.degree_id = d.id
            INNER JOIN classrooms cs ON st.classroom_id = cs.id
            INNER JOIN periods p ON st.period_id = p.id
            WHERE
                u.id = ? AND u.role_id = 4 AND st.is_active = 1
        ';
        
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $id_user);
        $query->execute();
        return [
            'row'  => $query->rowCount(),
            'query' => $query
        ];
    }
}
?>
