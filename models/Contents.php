<?php

class Contents extends Connect
{
    /*
     * Funcion para insertar un nuevo contenido.
     */
    public function insertOrUpdateContent($id = null, $title, $description, $type, $teacher_course_id, $file, $video)
    {
        if(empty($title) OR empty($description) OR empty($type) OR empty($teacher_course_id) OR empty($file)){
            $answer = [
                'status' => false,
                'msg'    => 'Todos los campos son necesarios'
            ];
        }else{
            $conectar = parent::connection();
            parent::set_names();
            
            // Files
            $material      = $_FILES['file']['name'];
            $url_temp      = $_FILES['file']['tmp_name'];
            
            $dir         = '../uploads/'.rand(1000, 10000);
            if(!file_exists($dir)){
                mkdir($dir, 0777, true);
            }
            
            $destiny     = $dir.'/'.$material;
            
            $sql = '
                SELECT
                    *
                FROM
                    contents
                WHERE
                    id = ?
            ';
            
            $query  = $conectar->prepare($sql);
            $query->bindValue(1, $id);
            $query->execute();
            $data   = $query->fetch(PDO::FETCH_ASSOC);
            
            if($_FILES['file']['size'] > 15000000){
                $answer = [
                    'status' => false,
                    'msg'    => 'Solo se permiten archivos hasta 15MB'
                ];
            }else{
                if(empty($id)){
                    $sqlInsert = '
                        INSERT INTO
                            contents (title, description, file, type, teacher_course_id, video, created)
                        VALUES
                            (?, ?, ?, ?, ?, ?, now())
                    ';
                    
                    $queryInsert = $conectar->prepare($sqlInsert);
                    $queryInsert->bindValue(1, $title);
                    $queryInsert->bindValue(2, $description);
                    $queryInsert->bindValue(3, $destiny);
                    $queryInsert->bindValue(4, $type);
                    $queryInsert->bindValue(5, $teacher_course_id);
                    $queryInsert->bindValue(6, $video);
                    $request     = $queryInsert->execute();
                    move_uploaded_file($url_temp, $destiny);
                    $action = 1;
                }else{
                    if(empty($_FILES['file']['name'])){
                        $sqlUpdate = '
                            UPDATE
                                contents
                            SET
                                title = ?,
                                description = ?,
                                type = ?,
                                teacher_course_id = ?,
                                video = ?
                            WHERE
                                id = ?
                        ';
                        
                        $queryUpdate = $conectar->prepare($sqlUpdate);
                        $queryUpdate->bindValue(1, $title);
                        $queryUpdate->bindValue(2, $description);
                        $queryUpdate->bindValue(3, $type);
                        $queryUpdate->bindValue(4, $teacher_course_id);
                        $queryUpdate->bindValue(5, $video);
                        $queryUpdate->bindValue(6, $id);
                        $request     = $queryUpdate->execute();
                        $action = 2;
                    }else{
                        $sqlUpdate = '
                            UPDATE
                                contents
                            SET
                                title = ?,
                                description = ?,
                                type = ?,
                                file = ?,
                                teacher_course_id = ?,
                                video = ?
                            WHERE
                                id = ?
                        ';
                        
                        $queryUpdate = $conectar->prepare($sqlUpdate);
                        $queryUpdate->bindValue(1, $title);
                        $queryUpdate->bindValue(2, $description);
                        $queryUpdate->bindValue(3, $type);
                        $queryUpdate->bindValue(4, $destiny);
                        $queryUpdate->bindValue(5, $teacher_course_id);
                        $queryUpdate->bindValue(6, $video);
                        $queryUpdate->bindValue(7, $id);
                        $request     = $queryUpdate->execute();
                        if($data['file'] != ''){
                            unlink($data['file']);
                        }
                        move_uploaded_file($url_temp, $destiny);
                        $action = 3;
                    }
                }
                if($request > 0){
                    if($action == 1){
                        $answer = [
                            'status' => true,
                            'msg'    => 'Contenido creado correctamente'
                        ];
                    }else{
                        $answer = [
                            'status' => true,
                            'msg'    => 'Contenido actualizado correctamente'
                        ];
                    }
                }
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }
    /*
     * Funcion para obtener todos los contenidos activos.
     */
    public function getContents()
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                * 
            FROM 
                contents
            WHERE
                is_active = 1
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        
        return $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /*
     * Funcion para eliminar un contenido (eliminado logico).
     */
    public function deleteContentById($id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                contents
            SET
                is_active = 0
            WHERE
                id = ?
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /*
     * Funcion para cambiar el estado de un contenido (eliminado visual).
     */
    public function statusBloqContentById($id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                contents
            SET
                status = 0
            WHERE
                id = ?
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /*
     * Funcion para cambiar el estado de un contenido (mostrar visual).
     */
    public function statusDesbloqContentById($id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                contents
            SET
                status = 1
            WHERE
                id = ?
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /*
     * Funcion para obtener informacion de un contenido mediante su ID.
     */
    public function getContentById($id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                *
            FROM
                contents
            WHERE
                id = ?
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /*
     * Funcion para obtener informacion de un contenido mediante el curso docente.
     */
    public function getContentByTeacherCourseId($teacher_course_id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = '
            SELECT
                c.id,
                c.title,
                c.file,
                c.description,
                c.video,
                c.status,
                tc.id as idTeacherCourse
            FROM
                contents as c
            INNER JOIN teacher_courses tc ON c.teacher_course_id = tc.id
            WHERE
                tc.id = ? AND c.is_active = 1
        ';
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $teacher_course_id);
        $stmt->execute();
        return [
            'rowContent'   => $stmt->rowCount(),
            'queryContent' => $stmt
        ];
    }
}

?>
