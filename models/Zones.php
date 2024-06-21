<?php

class Zones extends Database
{
    /*
     * Funcion para obtener la condicion adicional basada en $_SESSION['role_id']
     */
    private function getSessionCondition($idr)
    {
        if ($_SESSION['role_id'] == 1) {
            return '';
        } else {
            return 'AND idr = '.$idr;
        }
    }
    /*
     * Funcion para insertar zonas por medio de un formulario
     */
    public function insertZone($name, $idr)
    {
        
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = '
            SELECT
                *
            FROM
                zones
            WHERE
                name = ? AND is_active != 0 AND idr = ?
        ';
        
        $query  = $conectar->prepare($sql);
        $query->bindValue(1, $name);
        $query->bindValue(2, $idr);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if($result){
            return false;
        }else{
            $sqlInsert = "
                INSERT INTO
                    zones (name, idr, created)
                VALUES
                    (?, ?, now())
            ";
            
            $stmtInsert = $conectar->prepare($sqlInsert);
            $stmtInsert->bindValue(1, $name);
            $stmtInsert->bindValue(2, $idr);
            return $stmtInsert->execute();
        }
    }
    /*
     * Funcion para actualizar zonas por medio de un formulario
     */
    public function updateZone($id, $name, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            UPDATE
                zones
            SET
                name = ?,
                idr = ?
            WHERE
                id = ?
        ";
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $idr);
        $stmt->bindValue(3, $id);
        return $stmt->execute();
    }
    /*
     * Funcion para traer todas las zonas registradas hasta el momento
     */
    public function getZones($idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        // Determinar la condición basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);
        
        $sql = "
            SELECT
                *
            FROM
                zones
            WHERE
                is_active = 1 ".$condition;
        
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
    
    /*
     * Funcion para eliminar totalmente registros de zonas existentes por su ID
     */
    public function deleteZoneById($id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        // Determinar la condición basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);
        
        $sql = "
            UPDATE
                zones
            SET
                is_active = 0
            WHERE
                id = ? ".$condition;
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        
        return $stmt->execute();
    }
    
    /*
     * Funcion para traer las zonas mediante el ID de la zona
     */
    public function getZoneById($id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        // Determinar la condición basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);
        
        $sql = "
            SELECT
                *
            FROM
                zones
            WHERE
                id = ? ".$condition;
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /*
     *  Funcion para actualizar la sede
     */
    public function updateAssignedCampus($id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                zones
            SET
                idr = ?
            WHERE
                id = ?
        ";
        $sql    = $conectar->prepare($sql);
        $sql->bindValue(1, $idr);
        $sql->bindValue(2, $id);
        return $sql->execute();
    }
}
?>
