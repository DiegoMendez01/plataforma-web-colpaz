<?php

class Grades extends Connect
{
    /*
     * Funcion para insertar/registrar grados por medio de un formulario
     */
    public function insertGrades($name, $description = null)
    {
        $conectar = parent::connection();
        parent::set_names();

        // Concatenar y formatear las credenciales para generar el token
        $token = sprintf("%s-%s-%s-%s-%s", substr(md5($name), 0, 8), substr(md5($name), 0, 4), substr(md5(uniqid()), 0, 4), substr(md5(uniqid()), 0, 4), substr(md5(uniqid()), 0, 8));

        $sql = "
            INSERT INTO
                grades (name, description, token, created)
            VALUES
                (?, ?, ?, now())
        ";

        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $description);
        $stmt->bindValue(3, $token);
        $stmt->execute();

        return $result = $stmt->fetchAll();
    }

    /*
     * Funcion para actualizar registros de grados existentes por su ID
     */
    public function updateGradeById($id, $name, $description = null)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            UPDATE
                grades
            SET
                name = ?, description = ?
            WHERE
                id = ?
        ";

        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $description);
        $stmt->bindValue(3, $id);
        $stmt->execute();

        return $result = $stmt->fetchAll();
    }

    /*
     * Funcion para traer todos los grados registrados hasta el momento
     */
    public function getGrades()
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            SELECT
                *
            FROM
                grades
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
    public function deleteGradeById($id)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            UPDATE
                grades
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
    public function getGradeById($id)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            SELECT
                *
            FROM
                grades
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
