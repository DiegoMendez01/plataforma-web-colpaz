<?php

Class Menus extends Database
{
    /* TODO Traer los menus del sistema */
    public function getMenusByRole($role_id)
    {
        $conectar = parent::connection();
        
        $sql = '
            SELECT
                mr.id,
                mr.menu_id,
                mr.role_id,
                mr.permission,
                m.group,
                mr.created,
                mr.is_active,
                m.name,
                m.route,
                m.identification
            FROM
                menu_roles as mr
            INNER JOIN menus m ON mr.menu_id = m.id
            WHERE
                mr.role_id = ?
        ';
        
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $role_id);
        $query->execute();
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    /* TODO Habilitar menus del sistema */
    public function enabled($id)
    {
        $conectar = parent::connection();
        
        $sql = '
            UPDATE
                menu_roles
            SET
                permission = "Si"
            WHERE
                id = ?
        ';
        
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $id);
        $query->execute();
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    /* TODO Deshabilitar menus del sistema */
    public function disabled($id)
    {
        $conectar = parent::connection();
        
        $sql = '
            UPDATE
                menu_roles
            SET
                permission = "No"
            WHERE
                id = ?
        ';
        
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $id);
        $query->execute();
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>