<?php

require_once (__DIR__."/../config/database.php");

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
     * Funcion para insertar una nueva actividad.
     */
    public function insertAssessment($title, $comment, $percentage, $content_id, $file, $date_limit, $url_temp, $destiny, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();

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

        return $request;
    }
    /*
     * Funcion para actualizar una nueva actividad.
     */
    public function updateAssessment($id, $title, $comment, $percentage, $content_id, $file, $date_limit, $url_temp, $destiny, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();

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

            return $request;
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
            return $request;
        }
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
    /*
     * Funcion para obtener informacion de un contenido mediante su ID.
     */
    public function getAssessmentById($id, $idr)
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
                id = ? AND is_active = 1 ".$condition;
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /*
     * Funcion para eliminar una actividad (eliminado logico).
     */
    public function deleteAssessmentById($id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        $condition = $this->getSessionCondition($idr);
        
        $sql = "
            UPDATE
                assessments
            SET
                is_active = 0
            WHERE
                id = ? ".$condition;
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}