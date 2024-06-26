<?php

require_once (__DIR__."/../config/database.php");

class Periods extends Database
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
     * Funcion para insertar un nuevo periodo por formulario
     */
    public function createPeriod($name, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = '
            SELECT
                *
            FROM
                periods
            WHERE
                name = ? AND is_active != 0 AND idr = ?
        ';
        
        $query  = $conectar->prepare($sql);
        $query->bindValue(1, $name);
        $query->bindValue(2, $idr);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        if($result){
            return false;
        }else{
            $sqlInsert = "
                INSERT INTO
                    periods (name, idr, created)
                VALUES (?, ?, now())
            ";
            $stmtInsert = $conectar->prepare($sqlInsert);
            $stmtInsert->bindValue(1, $name);
            $stmtInsert->bindValue(2, $idr);
            return $stmtInsert->execute();
        }
    }
    /*
     * Funcion para actualizar un nuevo periodo por formulario
     */
    public function updatePeriod($id, $name, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = '
            SELECT
                *
            FROM
                periods
            WHERE
                name = ? AND id != ? AND is_active != 0 AND idr = ?
        ';
        
        $query  = $conectar->prepare($sql);
        $query->bindValue(1, $name);
        $query->bindValue(2, $id);
        $query->bindValue(3, $idr);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        if($result){
            return false;
        }else{
            $sqlUpdate = "
                UPDATE
                    periods
                SET
                    name = ?,
                    idr = ?
                WHERE
                    id = ?
            ";
            
            $stmtUpdate = $conectar->prepare($sqlUpdate);
            $stmtUpdate->bindValue(1, $name);
            $stmtUpdate->bindValue(2, $idr);
            $stmtUpdate->bindValue(3, $id);
            return $stmtUpdate->execute();
        }
    }
    /*
     * Funcion para obtener todos los periodos
     */
    public function getPeriods($idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        // Determinar la condición basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);
        
        $sql = "
            SELECT
                *
            FROM 
                periods
            WHERE
                is_active = 1 ".$condition;
        
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }

    /*
     * Funcion para obtener informacion de un periodo por su ID
     */
    public function getPeriodsById($id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        // Determinar la condición basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);
        
        $sql = "
            SELECT
                *
            FROM
                periods
            WHERE
                id = ? AND is_active = 1 ".$condition;

        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /*
     * Funcion para actualizar informacion de un periodo
     */
    public function deletePeriodById($id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        // Determinar la condición basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);
        
        $sql = "
            UPDATE
                periods
            SET
                is_active = 0
            WHERE
                id = ? ".$condition;
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        
        return $stmt->execute();
    }
    /*
     *  Funcion para actualizar la sede
     */
    public function updateAssignedCampus($id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            UPDATE
                periods
            SET
                idr = ?
            WHERE
                id = ?
        ";
        $sql    = $conectar->prepare($sql);
        $sql->bindValue(1, $idr);
        $sql->bindValue(2, $id);
        return $sql->execute();
    }
}
