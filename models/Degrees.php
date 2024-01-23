<?php

class Degrees extends Connect
{
    /*
     * Funcion para insertar/registrar grados por medio de un formulario
     */
    public function insertDegree($name)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            INSERT INTO
                degrees (name, created)
            VALUES
                (?, now())
        ";
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $name);
        $stmt->execute();

        return $result = $stmt->fetchAll();
    }

    /*
     * Funcion para actualizar registros de grados existentes por su ID
     */
    public function updateDegreeById($id, $name)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            UPDATE
                degrees
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
     * Funcion para traer todos los grados registrados hasta el momento
     */
    public function getDegrees()
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            SELECT
                *
            FROM
                degrees
            WHERE
                is_active = 1
        ";

        $stmt = $conectar->prepare($sql);
        $stmt->execute();

        return $result = $stmt->fetchAll();
    }

    /*
     * Funcion para eliminar totalmente registros de grados existentes por su ID
     */
    public function deleteDegreeById($id)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            UPDATE
                degrees
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
     * Funcion para traer los grados mediante el ID del grado
     */
    public function getDegreeById($id)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            SELECT
                *
            FROM
                degrees
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
