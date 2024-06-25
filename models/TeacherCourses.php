<?php

class TeacherCourses extends Database
{
    /*
    * Función para obtener la condición adicional basada en $_SESSION['role_id']
    */
    private function getSessionCondition($idr, $alias = null)
    {
        if ($_SESSION['role_id'] == 1) {
            return '';
        } else {
            if ($alias) {
                return ' AND ' . $alias . '.idr = ' . $idr;
            } else {
                return ' AND idr = ' . $idr;
            }
        }
    }
    /*
     * Funcion para inscribir a un docente en un curso mediante un formulario
     */
    public function insertOrUpdateTeacherCourse($id = null, $user_id, $course_id, $classroom_id, $period_id, $degree_id, $idr)
    {
        if(empty($user_id) OR empty($course_id) OR empty($classroom_id) OR empty($period_id) OR empty($degree_id)){
            $answer = [
                'status' => false,
                'msg'    => 'Todos los campos son necesarios'
            ];
        }
        $conectar = parent::connection();
        parent::set_names();
        
        // Consulta para insertar
        $sql = '
            SELECT
                *
            FROM
                teacher_courses
            WHERE
                user_id = ? AND course_id = ? AND classroom_id = ? AND period_id = ? AND degree_id = ? AND is_active != 0 AND id != ? AND idr = ?
        ';
        
        $query  = $conectar->prepare($sql);
        $query->bindValue(1, $user_id);
        $query->bindValue(2, $course_id);
        $query->bindValue(3, $classroom_id);
        $query->bindValue(4, $period_id);
        $query->bindValue(5, $degree_id);
        $query->bindValue(6, $id);
        $query->bindValue(7, $idr);
        $query->execute();
        $resultInsert = $query->fetch(PDO::FETCH_ASSOC);
        
        if($resultInsert > 0){
            $answer = [
                'status' => false,
                'msg'    => 'El grado, curso, materia y profesor existen, seleccione otro'
            ];
        }else{
            if(empty($id)){
                $sqlInsert = "
                    INSERT INTO
                        teacher_courses (user_id, course_id, classroom_id, period_id, degree_id, idr, created, is_active) 
                    VALUES (?, ?, ?, ?, ?, ?, now(), 1)
                ";
                
                $stmtInsert = $conectar->prepare($sqlInsert);
                $stmtInsert->bindValue(1, $user_id);
                $stmtInsert->bindValue(2, $course_id);
                $stmtInsert->bindValue(3, $classroom_id);
                $stmtInsert->bindValue(4, $period_id);
                $stmtInsert->bindValue(5, $degree_id);
                $stmtInsert->bindValue(6, $idr);
                $request    = $stmtInsert->execute();
                $action     = 1;
            }else{
                $sqlUpdate = "
                    UPDATE
                        teacher_courses
                    SET
                        user_id   = ?,
                        course_id = ?,
                        classroom_id = ?,
                        period_id = ?,
                        idr = ?
                    WHERE
                        id = ?
                ";
                
                $stmtUpdate = $conectar->prepare($sqlUpdate);
                $stmtUpdate->bindValue(1, $user_id);
                $stmtUpdate->bindValue(2, $course_id);
                $stmtUpdate->bindValue(3, $classroom_id);
                $stmtUpdate->bindValue(4, $period_id);
                $stmtUpdate->bindValue(5, $idr);
                $stmtUpdate->bindValue(6, $id);
                $request    = $stmtUpdate->execute();
                $action     = 2;
            }
            
            if($request){
                if($action == 1){
                    $answer = [
                        'status' => true,
                        'msg'    => 'Curso Profesor creada correctamente'
                    ];
                }else{
                    $answer = [
                        'status' => true,
                        'msg'    => 'Curso Profesor actualizada correctamente'
                    ];
                }
            }else{
                $answer = [
                    'status' => false,
                    'msg'    => 'Error al crear el curso profesor'
                ];
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }
    /*
     * Funcion para obtener todos los cursos en los que un usuario esta inscrito
     */
    public function getTeacherCourses($idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        // Determinar la condición basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr, 'tc');
        
        $sql = "
            SELECT
                tc.id,
                u.name as nameTeacher,
                u.lastname,
                cr.name as nameClassroom,
                c.name as nameCourse,
                d.name as nameDegree,
                p.name as namePeriod,
                tc.idr,
                tc.is_active
            FROM 
                teacher_courses tc
            INNER JOIN users u ON tc.user_id = u.id
            INNER JOIN courses c ON tc.course_id = c.id
            INNER JOIN classrooms cr ON tc.classroom_id = cr.id
            INNER JOIN periods p ON tc.period_id = p.id
            INNER JOIN degrees d ON tc.degree_id = d.id
            WHERE
                tc.is_active = 1 ".$condition;
        
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
    
    /*
     * Funcion para desinscribir a un usuario de un curso (eliminado logico)
     */
    public function deleteTeacherCourseById($id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        // Determinar la condicion basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);

        $sql = "
            UPDATE
                teacher_courses
            SET
                is_active = 0
            WHERE
                id = ? ".$condition;
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);

        return $stmt->execute();
    }
    /*
     * Funcion para obtener informacion de la inscripcion de un usuario en un curso mediante el ID de inscripcion
     */
    public function getTeacherCourseById($id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        // Determinar la condicion basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);
        
        $sql = "
            SELECT
                *
            FROM
                teacher_courses
            WHERE
                id = ? ".$condition;
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /*
     * Funcion para obtener los usuarios por curso, si es rol docente por ID
     */
    public function getTeacherCourseByIdUser($id_user, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        // Determinar la condicion basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr, 'uc');
        
        $sql = '
            SELECT
                uc.id,
                uc.course_id,
                u.name as nameUser,
                c.name as nameCourse,
                cs.name as nameClassroom,
                d.name as nameDegree,
                p.name as namePeriod
            FROM
                teacher_courses as uc
            INNER JOIN users u ON uc.user_id = u.id
            INNER JOIN courses c ON uc.course_id = c.id
            INNER JOIN degrees d ON uc.degree_id = d.id
            INNER JOIN classrooms cs ON uc.classroom_id = cs.id
            INNER JOIN periods p ON uc.period_id = p.id
            WHERE
                u.id = ? AND u.role_id = 3 AND uc.is_active = 1 '.$condition;
        
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $id_user);
        $query->execute();

        return [
            'row'  => $query->rowCount(),
            'query' => $query
        ];
    }
    /*
     * Funcion para obtener los usuarios por curso, si es rol docente
     */
    public function getTeacherCoursesAllData($idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        // Determinar la condicion basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);
        
        $sql = '
            SELECT
                uc.id,
                u.name as nameTeacher,
                c.name as nameCourse,
                cs.name as nameClassroom,
                d.name as nameDegree,
                p.name as namePeriod
            FROM
                teacher_courses as uc
            INNER JOIN users u ON uc.user_id = u.id
            INNER JOIN courses c ON uc.course_id = c.id
            INNER JOIN degrees d ON uc.degree_id = d.id
            INNER JOIN classrooms cs ON uc.classroom_id = cs.id
            INNER JOIN periods p ON uc.period_id = p.id
            WHERE
                uc.is_active = 1 '.$condition;
        
        $query = $conectar->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}
