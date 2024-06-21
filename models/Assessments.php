<?php 

class Assessments extends Database
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
     * Funcion para insertar un nuevo contenido.
     */
    public function insertOrUpdate($id = null, $title, $comment, $percentage, $content_id, $file, $date_limit, $idr)
    {
        if(empty($title) OR empty($comment) OR empty($file) OR empty($content_id) OR empty($date_limit)){
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
            
            $dir         = '../docs/activities/'.rand(1000, 10000);
            if(!file_exists($dir)){
                mkdir($dir, 0777, true);
            }
            
            $destiny     = $dir.'/'.$material;
            
            $sql = '
                SELECT
                    *
                FROM
                    assessments
                WHERE
                    id = ? AND idr = ?
            ';
            
            $query  = $conectar->prepare($sql);
            $query->bindValue(1, $id);
            $query->bindValue(2, $idr);
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
                            assessments (title, comment, percentage, file, content_id, date_limit, idr, created)
                        VALUES
                            (?, ?, ?, ?, ?, ?, ?, now())
                    ';
                    
                    $queryInsert = $conectar->prepare($sqlInsert);
                    $queryInsert->bindValue(1, $title);
                    $queryInsert->bindValue(2, $comment);
                    $queryInsert->bindValue(3, $percentage);
                    $queryInsert->bindValue(4, $destiny);
                    $queryInsert->bindValue(5, $content_id);
                    $queryInsert->bindValue(6, $date_limit);
                    $queryInsert->bindValue(7, $idr);
                    $request     = $queryInsert->execute();
                    move_uploaded_file($url_temp, $destiny);
                    $action = 1;
                }else{
                    if(empty($_FILES['file']['name'])){
                        $sqlUpdate = '
                            UPDATE
                                assessments
                            SET
                                title = ?,
                                comment = ?,
                                content_id = ?,
                                date_limit = ?,
                                percentage = ?
                            WHERE
                                id = ? AND idr = ?
                        ';
                        
                        $queryUpdate = $conectar->prepare($sqlUpdate);
                        $queryUpdate->bindValue(1, $title);
                        $queryUpdate->bindValue(2, $comment);
                        $queryUpdate->bindValue(3, $content_id);
                        $queryUpdate->bindValue(4, $date_limit);
                        $queryUpdate->bindValue(5, $percentage);
                        $queryUpdate->bindValue(6, $id);
                        $queryUpdate->bindValue(7, $idr);
                        $request     = $queryUpdate->execute();
                        $action = 2;
                        
                        $files = scandir('../docs/activities/');
                        foreach ($files as $file) {
                            if ($file != '.' && $file != '..') {
                                $path = '../docs/activities/' . $file; // Corregir la ruta del directorio
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
                                assessments
                            SET
                                title = ?,
                                comment = ?,
                                file = ?,
                                content_id = ?,
                                date_limit = ?,
                                percentage = ?
                            WHERE
                                id = ? AND idr = ?
                        ';
                        
                        $queryUpdate = $conectar->prepare($sqlUpdate);
                        $queryUpdate->bindValue(1, $title);
                        $queryUpdate->bindValue(2, $comment);
                        $queryUpdate->bindValue(3, $destiny);
                        $queryUpdate->bindValue(4, $content_id);
                        $queryUpdate->bindValue(5, $date_limit);
                        $queryUpdate->bindValue(6, $percentage);
                        $queryUpdate->bindValue(7, $id);
                        $queryUpdate->bindValue(8, $idr);
                        $request     = $queryUpdate->execute();
                        if($data['file'] != ''){
                            unlink($data['file']);
                        }
                        move_uploaded_file($url_temp, $destiny);
                        $action = 3;
                        
                        $files = scandir('../docs/activities/');
                        foreach ($files as $file) {
                            if ($file != '.' && $file != '..') {
                                $path = '../docs/activities/' . $file; // Corregir la ruta del directorio
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
                            'msg'    => 'Actividad creada correctamente'
                        ];
                    }else{
                        $answer = [
                            'status' => true,
                            'msg'    => 'Actividad actualizada correctamente'
                        ];
                    }
                }
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }
    /*
     * Funcion para obtener todas las evaluaciones activos.
     */
    public function getAssessments($idr, $content_id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $condition = $this->getSessionCondition($idr);

        $sql = "
            SELECT
                * 
            FROM 
                assessments
            WHERE
                is_active = 1 AND content_id = ? ".$condition;
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $content_id);
        $stmt->execute();
        
        return $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}