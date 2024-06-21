<?php

class HeaderContents extends Database
{
    /*
     * Funcion para insertar un nuevo contenido.
     */
    public function insertOrUpdateHeaderContent($id = null, $teacher_course_id, $supplementary_file, $curriculum_file, $header_video = null)
    {
        if(empty($supplementary_file) OR empty($teacher_course_id) OR empty($curriculum_file)){
            $answer = [
                'status' => false,
                'msg'    => 'Todos los campos son necesarios'
            ];
        }else{
            $conectar = parent::connection();
            parent::set_names();
            
            // Files
            $material      = $_FILES['supplementary_file']['name'];
            $url_temp      = $_FILES['supplementary_file']['tmp_name'];
            
            $dir         = '../docs/contents/'.rand(1000, 10000);
            if(!file_exists($dir)){
                mkdir($dir, 0777, true);
            }
            
            $destiny     = $dir.'/'.$material;
            
            // Files
            $material2      = $_FILES['curriculum_file']['name'];
            $url_temp2      = $_FILES['curriculum_file']['tmp_name'];
            
            $dir2         = '../docs/contents/'.rand(1000, 10000);
            if(!file_exists($dir2)){
                mkdir($dir2, 0777, true);
            }
            
            $destiny2     = $dir2.'/'.$material2;
            
            $sql = '
                SELECT
                    *
                FROM
                    header_contents
                WHERE
                    id = ?
            ';
            
            $query  = $conectar->prepare($sql);
            $query->bindValue(1, $id);
            $query->execute();
            $data   = $query->fetch(PDO::FETCH_ASSOC);
            
            if($_FILES['curriculum_file']['size'] > 15000000 OR $_FILES['supplementary_file']['size'] > 15000000){
                $answer = [
                    'status' => false,
                    'msg'    => 'Solo se permiten archivos hasta 15MB'
                ];
            }else{
                if(empty($id)){
                    $sqlInsert = '
                        INSERT INTO
                            header_contents (teacher_course_id, header_video, supplementary_file, curriculum_file, created)
                        VALUES
                            (?, ?, ?, ?, now())
                    ';
                    
                    $queryInsert = $conectar->prepare($sqlInsert);
                    $queryInsert->bindValue(1, $teacher_course_id);
                    $queryInsert->bindValue(2, $header_video);
                    $queryInsert->bindValue(3, $destiny);
                    $queryInsert->bindValue(4, $destiny2);
                    $request     = $queryInsert->execute();
                    move_uploaded_file($url_temp, $destiny);
                    move_uploaded_file($url_temp2, $destiny2);
                    $action = 1;
                }else{
                    if(empty($_FILES['curriculum_file']['name']) AND empty($_FILES['supplementary_file']['name'])){
                        $sqlUpdate = '
                            UPDATE
                                header_contents
                            SET
                                header_video = ?,
                                teacher_course_id = ?
                            WHERE
                                id = ?
                        ';
                        
                        $sqlUpdate = $conectar->prepare($sqlUpdate);
                        $sqlUpdate->bindValue(1, $header_video);
                        $sqlUpdate->bindValue(2, $teacher_course_id);
                        $sqlUpdate->bindValue(3, $id);
                        $request     = $sqlUpdate->execute();
                        $action = 2;
                        
                        $files = scandir('../docs/contents/');
                        foreach ($files as $file) {
                            if ($file != '.' && $file != '..') {
                                $path = '../docs/contents/' . $file; // Corregir la ruta del directorio
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
                                teacher_course_id = ?,
                                header_video = ?';
                        
                        $params = [$teacher_course_id, $header_video];
                        
                        // Verifica y actualiza el archivo principal
                        if(!empty($_FILES['supplementary_file']['name'])) {
                            $sqlUpdate .= ',
                                supplementary_file = ?';
                            $params[] = $destiny;
                        }
                        
                        // Verifica y actualiza el file_2
                        if(!empty($_FILES['curriculum_file']['name'])) {
                            $sqlUpdate .= ',
                                curriculum_file = ?';
                            $params[] = $destiny2;
                        }
                        
                        $sqlUpdate .= '
                            WHERE
                                id = ?';
                        
                        $params[] = $id;
                        
                        $queryUpdate = $conectar->prepare($sqlUpdate);
                        $request     = $queryUpdate->execute($params);
                        
                        if(!empty($_FILES['supplementary_file']['name'])){
                            if($data['supplementary_file'] != ''){
                                unlink($data['supplementary_file']);
                            }
                            move_uploaded_file($url_temp, $destiny);
                        }
                        
                        if(!empty($_FILES['curriculum_file']['name'])){
                            if($data['curriculum_file'] != ''){
                                unlink($data['curriculum_file']);
                            }
                            move_uploaded_file($url_temp2, $destiny2);
                        }
                        
                        $files = scandir('../docs/contents/');
                        foreach ($files as $file) {
                            if ($file != '.' && $file != '..') {
                                $path = '../docs/contents/' . $file; // Corregir la ruta del directorio
                                if (is_dir($path)) {
                                    // Elimina las carpetas vacías
                                    if (count(scandir($path)) == 2) {
                                        rmdir($path);
                                    }
                                }
                            }
                        }
                        
                        $action = 3;
                    }
                }
                if($request > 0){
                    if($action == 1){
                        $answer = [
                            'status' => true,
                            'msg'    => 'Encabezado de Contenido creado correctamente'
                        ];
                    }else{
                        $answer = [
                            'status' => true,
                            'msg'    => 'Encabezado de Contenido actualizado correctamente'
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
     * Funcion para eliminar un encabezado de contenido (eliminado logico).
     */
    public function deleteHeaderContentById($id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                header_contents
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
     * Funcion para obtener informacion de un encabezado de contenido mediante su ID.
     */
    public function getHeaderContentById($id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                *
            FROM
                header_contents
            WHERE
                id = ?
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /*
     * Funcion para traer todos las cabeceras de contenidos registrados hasta el momento
     */
    public function getHeaderContents()
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                *
            FROM
                header_contents
            WHERE
                is_active = 1
        ";
        
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        
        return $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /*
     * Funcion para obtener informacion de un encabezado de contenido mediante el docente.
     */
    public function getHeaderContentByTeacher($teacher_course_id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                *
            FROM
                header_contents
            WHERE
                teacher_course_id = ? AND is_active = 1
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $teacher_course_id);
        $stmt->execute();
        
        return $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>
