<?php

class Contents extends Database
{
    /*
     * Funcion para insertar un nuevo contenido.
     */
    public function insertOrUpdateContent($id = null, $title, $description, $header_content_id, $file, $video)
    {
        if(empty($title) OR empty($description) OR empty($file) OR empty($header_content_id)){
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
                            contents (title, description, file, header_content_id, video, created)
                        VALUES
                            (?, ?, ?, ?, ?, now())
                    ';
                    
                    $queryInsert = $conectar->prepare($sqlInsert);
                    $queryInsert->bindValue(1, $title);
                    $queryInsert->bindValue(2, $description);
                    $queryInsert->bindValue(3, $destiny);
                    $queryInsert->bindValue(4, $header_content_id);
                    $queryInsert->bindValue(5, $video);
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
                                header_content_id = ?,
                                video = ?
                            WHERE
                                id = ?
                        ';
                        
                        $queryUpdate = $conectar->prepare($sqlUpdate);
                        $queryUpdate->bindValue(1, $title);
                        $queryUpdate->bindValue(2, $description);
                        $queryUpdate->bindValue(3, $header_content_id);
                        $queryUpdate->bindValue(4, $video);
                        $queryUpdate->bindValue(5, $id);
                        $request     = $queryUpdate->execute();
                        $action = 2;
                        
                        $files = scandir('../uploads/');
                        foreach ($files as $file) {
                            if ($file != '.' && $file != '..') {
                                $path = '../uploads/' . $file; // Corregir la ruta del directorio
                                if (is_dir($path)) {
                                    // Elimina las carpetas vacías
                                    if (count(scandir($path)) == 2) {
                                        rmdir($path);
                                    }
                                }
                            }
                        }
                    }else{
                        $sqlUpdate = '
                            UPDATE
                                contents
                            SET
                                title = ?,
                                description = ?,
                                file = ?,
                                header_content_id = ?,
                                video = ?
                            WHERE
                                id = ?
                        ';
                        
                        $queryUpdate = $conectar->prepare($sqlUpdate);
                        $queryUpdate->bindValue(1, $title);
                        $queryUpdate->bindValue(2, $description);
                        $queryUpdate->bindValue(3, $destiny);
                        $queryUpdate->bindValue(4, $header_content_id);
                        $queryUpdate->bindValue(5, $video);
                        $queryUpdate->bindValue(6, $id);
                        $request     = $queryUpdate->execute();
                        if($data['file'] != ''){
                            unlink($data['file']);
                        }
                        move_uploaded_file($url_temp, $destiny);
                        $action = 3;
                        
                        $files = scandir('../uploads/');
                        foreach ($files as $file) {
                            if ($file != '.' && $file != '..') {
                                $path = '../uploads/' . $file; // Corregir la ruta del directorio
                                if (is_dir($path)) {
                                    // Elimina las carpetas vacías
                                    if (count(scandir($path)) == 2) {
                                        rmdir($path);
                                    }
                                }
                            }
                        }
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
    public function getContentByTeacherCourseId($teacher_course_id, $header_content_id)
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
            INNER JOIN header_contents hc ON c.header_content_id = hc.id
            INNER JOIN teacher_courses tc ON hc.teacher_course_id = tc.id
            WHERE
                tc.id = ? AND c.is_active = 1 AND hc.id = ?
        ';
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $teacher_course_id);
        $stmt->bindValue(2, $header_content_id);
        $stmt->execute();
        return [
            'rowContent'   => $stmt->rowCount(),
            'queryContent' => $stmt
        ];
    }
}

?>
