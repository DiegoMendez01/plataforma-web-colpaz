<?php

class Zones extends Connect
{
    /*
     * Funcion para insertar/registrar zonas por medio de un formulario
     */
    public function insertOrUpdateZone($id = null, $name)
    {
        if(empty($name)){
            $answer = [
                'status' => false,
                'msg'    => 'Todos los campos son necesarios'
            ];
        }else{
            $conectar = parent::connection();
            parent::set_names();
            
            $sql = '
                SELECT
                    *
                FROM
                    zones
                WHERE
                    name = ? AND id != ? AND is_active != 0
            ';
            
            $query  = $conectar->prepare($sql);
            $query->bindValue(1, $name);
            $query->bindValue(2, $id);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            
            if($result){
                $answer = [
                    'status' => false,
                    'msg'    => 'La zona ya existe'
                ];
            }else{
                if(empty($id)){
                    $sqlInsert = "
                        INSERT INTO
                            zones (name, created)
                        VALUES
                            (?, now())
                    ";
                    
                    $stmtInsert = $conectar->prepare($sqlInsert);
                    $stmtInsert->bindValue(1, $name);
                    $request    = $stmtInsert->execute();
                    $action     = 1;
                }else{
                    $sqlUpdate = "
                        UPDATE
                            zones
                        SET
                            name = ?
                        WHERE
                            id = ?
                    ";
                    
                    $stmtUpdate = $conectar->prepare($sqlUpdate);
                    $stmtUpdate->bindValue(1, $name);
                    $stmtUpdate->bindValue(2, $id);
                    $request    = $stmtUpdate->execute();
                    $action     = 2;
                }
                
                if($request){
                    if($action == 1){
                        $answer = [
                            'status' => true,
                            'msg'    => 'Zona creada correctamente'
                        ];
                    }else{
                        $answer = [
                            'status' => true,
                            'msg'    => 'Zona actualizada correctamente'
                        ];
                    }
                }else{
                    $answer = [
                        'status' => false,
                        'msg'    => 'Error al crear la zona'
                    ];
                }
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
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
        
        return $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
