<?php

class Roles extends Connect
{
    /*
     * Funcion para insertar/registrar un nuevo rol
     */
    public function insertRole($rol_name, $rol_functions, $rol_created, $rol_idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            INSERT INTO
                roles (name, functions, created, idr, is_active) 
            VALUES (?, ?, ?, ?, 1)
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $rol_name);
        $stmt->bindValue(2, $rol_functions);
        $stmt->bindValue(3, $rol_created);
        $stmt->bindValue(4, $rol_idr);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /*
     * Funcion para obtener todos los roles
     */
    public function getRoles()
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            SELECT
                *
            FROM 
                roles
            WHERE
                is_active = 1
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();

        return $result = $stmt->fetchAll();
    }

    /*
     * Funcion para obtener informacion de un rol por su ID
     */
    public function getRolesById($rol_id)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            SELECT
                *
            FROM
                roles
            WHERE
                id = ? AND is_active = 1
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $rol_id);
        $stmt->execute();

        return $result = $stmt->fetchAll();
    }

    
    /*
     * Funcion para eliminar logicamente un rol
     */
    public function deleteRolesById($rol_id)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            UPDATE
                roles
            SET
                is_active = 0
            WHERE
                id = ? AND is_active = 1
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $rol_id);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}

