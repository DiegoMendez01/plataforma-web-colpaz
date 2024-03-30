<?php

class IdentificationTypes extends Connect
{
    /*
     * Funcion para obtener todos los tipos de identificacion
     */
    public function getIdentificationTypes()
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            SELECT
                *
            FROM 
                identification_types
            WHERE
                is_active = 1
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();

        return $result = $stmt->fetchAll();
    }
}
?>