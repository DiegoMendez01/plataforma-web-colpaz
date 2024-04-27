<?php

Class Menus extends Database
{
    /*
     * Función para obtener la condición adicional basada en $_SESSION['role_id']
     */
    private function getSessionCondition($idr, $status)
    {
        if ($_SESSION['role_id'] == 1) {
            return ''; // Sin condición adicional si role_id es 1
        } else if($status) {
            return 'AND mr.idr = '.$idr;
        }else{
            return 'AND idr = '.$idr;
        }
    }
    /* TODO Traer los menus del sistema */
    public function getMenusByRole($role_id, $idr)
    {
        $conectar = parent::connection();
        
        $conditions = $this->getSessionCondition($idr, true);
        
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
                mr.role_id = ?'.$conditions;
        
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $role_id);
        $query->execute();
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    /* TODO Habilitar menus del sistema */
    public function updateMenuEnable($id, $idr)
    {
        $conectar = parent::connection();
        
        $conditions = $this->getSessionCondition($idr, false);
        
        $sql = '
            UPDATE
                menu_roles
            SET
                permission = "Si"
            WHERE
                id = ? '.$conditions;
        
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $id);
        $query->execute();
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    /* TODO Deshabilitar menus del sistema */
    public function updateMenuDisabled($id, $idr)
    {
        $conectar = parent::connection();
        
        $conditions = $this->getSessionCondition($idr, false);
        
        $sql = '
            UPDATE
                menu_roles
            SET
                permission = "No"
            WHERE
                id = ? '.$conditions;
        
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $id);
        $query->execute();
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>