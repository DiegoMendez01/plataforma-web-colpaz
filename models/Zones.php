<?php

class Zones extends Connect
{
    /*
     * Funcion para insertar/registrar zonas por medio de un formulario
     */
    public function insertZone($name)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            INSERT INTO
                zones (name, created)
            VALUES
                (?, now())
        ";

        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $name);
        $stmt->execute();

        return $result = $stmt->fetchAll();
    }

    /*
     * Funcion para actualizar registros de zonas existentes por su ID
     */
    public function updateZoneById($id, $name)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            UPDATE
                zones
            SET
                name = ?
            WHERE
                id = ?
        ";

        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $id);
        $stmt->execute();

        return $result = $stmt->fetchAll();
    }

    /*
     * Funcion para traer todas las zonas registradas hasta el momento
     */
    public function getZones()
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            SELECT
                *
            FROM
                zones
            WHERE
                is_active = 1
        ";

        $stmt = $conectar->prepare($sql);
        $stmt->execute();

        return $result = $stmt->fetchAll();
    }

    /*
     * Funcion para eliminar totalmente registros de zonas existentes por su ID
     */
    public function deleteZoneById($id)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            UPDATE
                zones
            SET
                is_active = 0
            WHERE
                id = ?
        ";

        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();

        return $result = $stmt->fetchAll();
    }

    /*
     * Funcion para traer las zonas mediante el ID de la zona
     */
    public function getZoneById($id)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            SELECT
                *
            FROM
                zones
            WHERE
                id = ?
        ";

        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();

        return $result = $stmt->fetchAll();
    }
}
?>
