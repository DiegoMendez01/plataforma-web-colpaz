<?php

class PeriodsModel extends Connect
{
    /*
     * Funcion para insertar/registrar un nuevo periodo
     */
    public function insertPeriod($period_name, $period_start_date, $period_end_date, $period_created, $period_idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            INSERT INTO
                periods (name, start_date, end_date, created, idr, is_active) 
            VALUES (?, ?, ?, ?, ?, 1)
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $period_name);
        $stmt->bindValue(2, $period_start_date);
        $stmt->bindValue(3, $period_end_date);
        $stmt->bindValue(4, $period_created);
        $stmt->bindValue(5, $period_idr);
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
    public function getPeriodsById($period_id)
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
        $stmt->bindValue(1, $period_id);
        $stmt->execute();

        return $result = $stmt->fetchAll();
    }

    /*
     * Funcion para actualizar informacion de un periodo
     */
    public function updatePeriods($period_id, $period_name, $period_start_date, $period_end_date, $period_created, $period_idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            UPDATE
                periods
            SET
                name = ?,
                start_date = ?,
                end_date = ?,
                created = ?,
                idr = ?
            WHERE
                id = ? AND is_active = 1
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $period_name);
        $stmt->bindValue(2, $period_start_date);
        $stmt->bindValue(3, $period_end_date);
        $stmt->bindValue(4, $period_created);
        $stmt->bindValue(5, $period_idr);
        $stmt->bindValue(6, $period_id);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /*
     * Funcion para eliminar logicamente un periodo
     */
    public function deletePeriodsById($period_id)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            UPDATE
                periods
            SET
                is_active = 0
            WHERE
                id = ? AND is_active = 1
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $period_id);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
