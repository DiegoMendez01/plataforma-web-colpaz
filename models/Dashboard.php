<?php

require_once (__DIR__."/../config/database.php");

class Dashboard extends Database
{
    /*
     * Funcion para contar el total de usuarios
     */
    public function countTable($table)
    {
        
        $conectar = parent::connection();
        parent::set_names();
            
        $sql = '
            SELECT
                COUNT(*) as total
            FROM
                '.$table.'
            WHERE
                is_active = 1
        ';
            
        $query  = $conectar->prepare($sql);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}

?>
