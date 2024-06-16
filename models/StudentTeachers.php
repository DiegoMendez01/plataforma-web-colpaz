<?php

class StudentTeachers extends Database
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
     * Funcion para inscribir a un estudiante en un curso mediante un formulario
     */
    public function insertOrUpdateStudentTeacher($id = null, $user_id, $teacher_course_id, $period_id, $idr)
    {
        if(empty($user_id) OR empty($teacher_course_id) OR empty($period_id)){
            $answer = [
                'status' => false,
                'msg'    => 'Todos los campos son necesarios'
            ];
        }else{
            $conectar = parent::connection();
            parent::set_names();
            
            // Consulta para insertar
            $sql = '
                SELECT
                    *
                FROM
                    student_teachers
                WHERE
                    user_id = ? AND teacher_course_id = ? AND period_id = ? AND is_active != 0 AND id != ? AND idr = ?';
            
            $query  = $conectar->prepare($sql);
            $query->bindValue(1, $user_id);
            $query->bindValue(2, $teacher_course_id);
            $query->bindValue(3, $period_id);
            $query->bindValue(4, $id);
            $query->bindValue(5, $idr);
            $query->execute();
            $resultInsert = $query->fetch(PDO::FETCH_ASSOC);
            
            if($resultInsert > 0){
                $answer = [
                    'status' => false,
                    'msg'    => 'El grado, profesor materia y periodo existen, seleccione otro'
                ];
            }else{
                if(empty($id)){
                    $sqlInsert = "
                        INSERT INTO
                            student_teachers (user_id, teacher_course_id, period_id, idr, created, is_active) 
                        VALUES (?, ?, ?, now(), 1)
                    ";
                    $stmtInsert = $conectar->prepare($sqlInsert);
                    $stmtInsert->bindValue(1, $user_id);
                    $stmtInsert->bindValue(2, $teacher_course_id);
                    $stmtInsert->bindValue(3, $period_id);
                    $stmtInsert->bindValue(4, $idr);
                    $request    = $stmtInsert->execute();
                    $action     = 1;
                }else{
                    $sqlUpdate = "
                        UPDATE
                            student_teachers
                        SET
                            user_id   = ?,
                            teacher_course_id = ?,
                            period_id = ?,
                            idr = ?
                        WHERE
                            id = ?
                    ";
                    
                    $stmtUpdate = $conectar->prepare($sqlUpdate);
                    $stmtUpdate->bindValue(1, $user_id);
                    $stmtUpdate->bindValue(2, $teacher_course_id);
                    $stmtUpdate->bindValue(3, $period_id);
                    $stmtUpdate->bindValue(4, $idr);
                    $stmtUpdate->bindValue(5, $id);
                    $request    = $stmtUpdate->execute();
                    $action     = 2;
                }
                
                if($request){
                    if($action == 1){
                        $answer = [
                            'status' => true,
                            'msg'    => 'Estudiante Profesor creada correctamente'
                        ];
                    }else{
                        $answer = [
                            'status' => true,
                            'msg'    => 'Estudiante Profesor actualizada correctamente'
                        ];
                    }
                }else{
                    $answer = [
                        'status' => false,
                        'msg'    => 'Error al crear el estudiante profesor'
                    ];
                }
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }
    /*
     * Funcion para obtener todos los cursos en los que un usuario esta inscrito
     */
    public function getStudentTeacher($idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        // Determinar la condición basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);
        
        $sql = "
            SELECT
                * 
            FROM 
                student_teachers
            WHERE
                is_active = 1 ".$condition;
        
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
    /*
     * Funcion para desinscribir a un usuario de un curso (eliminado logico)
     */
    public function deleteStudentTeacherById($id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        // Determinar la condición basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);
        
        $sql = "
            UPDATE
                student_teachers
            SET
                is_active = 0
            WHERE
                id = ? ".$condition;
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return true;
    }
    /*
     * Funcion para obtener informacion de la inscripcion de un usuario en un curso mediante el ID de inscripcion
     */
    public function getStudentTeacherById($id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        // Determinar la condición basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);
        
        $sql = "
            SELECT
                *
            FROM
                student_teachers
            WHERE
                id = ? ".$condition;
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
}
?>
