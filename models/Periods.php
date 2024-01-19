<?php

class Periods extends Connect
{
    /*
     * Funcion para insertar/registrar un nuevo periodo
     */
    public function insertPeriod($name)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            INSERT INTO
                periods (name, created) 
            VALUES (?, now())
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $name);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    /*
     * Funcion para actualizar registros de periodos
     */
    public function updatePeriodById($id, $name)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                periods
            SET
                name = ?
            WHERE
                id = ?
        ";
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $id);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    /*
     * Funcion para obtener todos los periodos
     */
    public function getPeriods()
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                *
            FROM 
                periods
            WHERE
                is_active = 1
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }

    /*
     * Funcion para obtener informacion de un periodo por su ID
     */
    public function getPeriodsById($id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                *
            FROM
                periods
            WHERE
                id = ? AND is_active = 1
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }

    /*
     * Funcion para actualizar informacion de un periodo
     */
    public function deletePeriodById($id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                periods
            SET
                is_active = 0
            WHERE
                id = ?
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
}
