<?php

class Roles extends Connect
{
    /*
     * Funcion para insertar/registrar un nuevo rol
     */
    public function insertRole($name, $functions)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            INSERT INTO
                roles (name, functions, created) 
            VALUES (?, ?, now())
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $functions);
        $stmt->execute();

        return $stmt->fetchAll();
    }
    /*
     * Funcion para actualizar registros de cursos existentes por su ID
     */
    public function updateRoleById($id, $name, $functions)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                roles
            SET
                name = ?, functions = ?
            WHERE
                id = ?
        ";
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $functions);
        $stmt->bindValue(3, $id);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
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
                is_active = 1 AND id <> 1
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
    public function deleteRolesById($id)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            UPDATE
                roles
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

