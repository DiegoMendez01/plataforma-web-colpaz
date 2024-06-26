<?php

require_once (__DIR__."/../config/database.php");

class HeaderContents extends Database
{
    /*
     * Funcion para obtener la condicion adicional basada en $_SESSION['role_id']
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
    public function createHeaderContent($teacher_course_id, $supplementary_file, $curriculum_file, $header_video = null, $destiny, $destiny2, $url_temp, $url_temp2, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sqlInsert = '
            INSERT INTO
                header_contents (teacher_course_id, header_video, supplementary_file, curriculum_file, idr, created)
            VALUES
                (?, ?, ?, ?, ?, now())
        ';
        
        $queryInsert = $conectar->prepare($sqlInsert);
        $queryInsert->bindValue(1, $teacher_course_id);
        $queryInsert->bindValue(2, $header_video);
        $queryInsert->bindValue(3, $destiny);
        $queryInsert->bindValue(4, $destiny2);
        $queryInsert->bindValue(5, $idr);
        $request     = $queryInsert->execute();
        move_uploaded_file($url_temp, $destiny);
        move_uploaded_file($url_temp2, $destiny2);
        return $request;
    }
     /*
     * Funcion para actualizar un contenido.
     */
    public function updateHeaderContent($id, $teacher_course_id, $supplementary_file, $curriculum_file, $header_video = null, $destiny, $destiny2, $url_temp, $url_temp2, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = '
            SELECT
                *
            FROM
                header_contents
            WHERE
                id = ? AND idr = ?
        ';
        
        $query  = $conectar->prepare($sql);
        $query->bindValue(1, $id);
        $query->bindValue(2, $idr);
        $query->execute();
        $data   = $query->fetch(PDO::FETCH_ASSOC);

        if(empty($_FILES['curriculum_file']['name']) AND empty($_FILES['supplementary_file']['name'])){
            $sqlUpdate = '
                UPDATE
                    header_contents
                SET
                    header_video = ?,
                    teacher_course_id = ?,
                    idr = ?
                WHERE
                    id = ?
            ';
            
            $sqlUpdate = $conectar->prepare($sqlUpdate);
            $sqlUpdate->bindValue(1, $header_video);
            $sqlUpdate->bindValue(2, $teacher_course_id);
            $sqlUpdate->bindValue(3, $idr);
            $sqlUpdate->bindValue(4, $id);
            $request     = $sqlUpdate->execute();
            
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

            return $request;
        }else{
            $sqlUpdate = '
                UPDATE
                    header_contents
                SET
                    teacher_course_id = ?,
                    header_video = ?,
                    idr = ?';
            
            $params = [$teacher_course_id, $header_video, $idr];
            
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
            
            return $request;
        }
    }
    /*
     * Funcion para obtener todos los contenidos activos.
     */
    public function getContents($idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        // Determinar la condición basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);
        
        $sql = "
            SELECT
                * 
            FROM 
                contents
            WHERE
                is_active = 1 ".$condition;

        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        
        return $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /*
     * Funcion para eliminar un encabezado de contenido (eliminado logico).
     */
    public function deleteHeaderContentById($id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        // Determinar la condición basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);
        
        $sql = "
            UPDATE
                header_contents
            SET
                is_active = 0
            WHERE
                id = ? ".$condition;

        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /*
     * Funcion para obtener informacion de un encabezado de contenido mediante su ID.
     */
    public function getHeaderContentById($id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        // Determinar la condición basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);
        
        $sql = "
            SELECT
                *
            FROM
                header_contents
            WHERE
                id = ? ".$condition;

        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /*
     * Funcion para traer todos las cabeceras de contenidos registrados hasta el momento
     */
    public function getHeaderContents($idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        // Determinar la condición basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);
        
        $sql = "
            SELECT
                *
            FROM
                header_contents
            WHERE
                is_active = 1 ".$condition;
        
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        
        return $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /*
     * Funcion para obtener informacion de un encabezado de contenido mediante el docente.
     */
    public function getHeaderContentByTeacher($teacher_course_id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        // Determinar la condición basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);
        
        $sql = "
            SELECT
                *
            FROM
                header_contents
            WHERE
                teacher_course_id = ? AND is_active = 1 ".$condition;
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $teacher_course_id);
        $stmt->execute();
        
        return $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>
