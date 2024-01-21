<?php

class UserCourses extends Connect
{
    /*
     * Funcion para inscribir a un usuario en un curso mediante un formulario
     */
    public function insertUserCourse($user_id, $course_id, $classroom_id, $period_id, $degree_id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        // Consulta para insertar
        $sql = '
            SELECT
                *
            FROM
                user_courses
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
                    user_courses (user_id, course_id, classroom_id, period_id, degree_id, created, is_active) 
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
     * Funcion para actualizar registros de asignaciones de usuarios por cursos
     */
    public function updateUserCourse($id, $user_id, $course_id, $classroom_id, $period_id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                user_courses
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
    public function deleteUserCourseById($id)
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
        $stmt->bindValue(1, $id);
        $stmt->execute();

        return true;
    }

    /*
     * Funcion para obtener informacion de la inscripcion de un usuario en un curso mediante el ID de inscripcion
     */
    public function getUserCourseById($id)
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
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
    /*
     * Funcion para obtener los usuarios por curso, si es rol docente
     */
    public function getUserCourseByTeacher($id_user)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = '
            SELECT
                uc.id,
                u.name as nameUser,
                c.name as nameCourse,
                cs.name as nameClassroom,
                d.name as nameDegree,
                p.name as namePeriod
            FROM
                user_courses as uc
            INNER JOIN users u ON uc.user_id = u.id
            INNER JOIN courses c ON uc.course_id = c.id
            INNER JOIN degrees d ON uc.degree_id = d.id
            INNER JOIN classrooms cs ON uc.classroom_id = cs.id
            INNER JOIN periods p ON uc.period_id = p.id
            WHERE
                u.id = ? AND u.role_id = 3 AND uc.is_active = 1
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
