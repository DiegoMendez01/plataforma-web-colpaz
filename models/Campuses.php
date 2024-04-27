<?php

class Campuses extends Database
{
    /*
     * Funcion para insertar un nuevo campus.
     */
    public function insertOrUpdateCampuse($idr = null, $name, $description)
    {
        if(empty($name) OR empty($description)){
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
                    campuses
                WHERE
                    name = ? AND idr != ? AND is_active != 0
            ';
            
            $query  = $conectar->prepare($sql);
            $query->bindValue(1, $name);
            $query->bindValue(2, $idr);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            
            if($result){
                $answer = [
                    'status' => false,
                    'msg'    => 'La sede ya existe'
                ];
            }else{
                if(empty($idr)){
                    $sqlInsert = "
                        INSERT INTO
                            campuses (name, description, created)
                        VALUES
                            (?, ?, now())
                    ";
                    
                    $stmtInsert = $conectar->prepare($sqlInsert);
                    $stmtInsert->bindValue(1, $name);
                    $stmtInsert->bindValue(2, $description);
                    $request    = $stmtInsert->execute();
                    $action     = 1;
                }else{
                    $sqlUpdate = "
                        UPDATE
                            campuses
                        SET
                            name        = ?,
                            description = ?
                        WHERE
                            idr = ?
                    ";
                    
                    $stmtUpdate = $conectar->prepare($sqlUpdate);
                    $stmtUpdate->bindValue(1, $name);
                    $stmtUpdate->bindValue(2, $description);
                    $stmtUpdate->bindValue(3, $idr);
                    $request    = $stmtUpdate->execute();
                    $action     = 2;
                }
                
                if($request){
                    if($action == 1){
                        $answer = [
                            'status' => true,
                            'msg'    => 'Sede creada correctamente'
                        ];
                    }else{
                        $answer = [
                            'status' => true,
                            'msg'    => 'Sede actualizada correctamente'
                        ];
                    }
                }else{
                    $answer = [
                        'status' => false,
                        'msg'    => 'Error al crear la sede'
                    ];
                }
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }
    /*
     * Funcion para obtener todos los campus activos.
     */
    public function getCampuses()
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                * 
            FROM 
                campuses
            WHERE
                is_active = 1
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
    /*
     * Funcion para eliminar un campus (eliminado logico).
     */
    public function deleteCampuseById($idr)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                campuses
            SET
                is_active = 0
            WHERE
                idr = ?
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $idr);
        $stmt->execute();
        
        return true;
    }
    /*
     * Funcion para obtener informacion de un campus mediante su ID.
     */
    public function getCampuseById($idr)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                *
            FROM
                campuses
            WHERE
                idr = ?
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $idr);
        $stmt->execute();
        
        return $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>
