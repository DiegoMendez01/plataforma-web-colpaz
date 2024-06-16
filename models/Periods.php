<?php

class Periods extends Database
{
    /*
     * Función para obtener la condición adicional basada en $_SESSION['role_id']
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
     * Funcion para insertar/actualizar un nuevo periodo
     */
    public function insertOrUpdatePeriod($id = null, $name, $idr)
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
                    periods
                WHERE
                    name = ? AND id != ? AND is_active != 0 AND idr = ?
            ';
            
            $query  = $conectar->prepare($sql);
            $query->bindValue(1, $name);
            $query->bindValue(2, $id);
            $query->bindValue(3, $idr);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            
            if($result){
                $answer = [
                    'status' => false,
                    'msg'    => 'El periodo academico ya existe'
                ];
            }else{
                if(empty($id)){
                    $sqlInsert = "
                        INSERT INTO
                            periods (name, idr, created)
                        VALUES (?, ?, now())
                    ";
                    $stmtInsert = $conectar->prepare($sqlInsert);
                    $stmtInsert->bindValue(1, $name);
                    $stmtInsert->bindValue(2, $idr);
                    $request    = $stmtInsert->execute();
                    $action     = 1;
                }else{
                    $sqlUpdate = "
                        UPDATE
                            periods
                        SET
                            name = ?,
                            idr = ?
                        WHERE
                            id = ?
                    ";
                    
                    $stmtUpdate = $conectar->prepare($sqlUpdate);
                    $stmtUpdate->bindValue(1, $name);
                    $stmtUpdate->bindValue(2, $idr);
                    $stmtUpdate->bindValue(3, $id);
                    $request    = $stmtUpdate->execute();
                    $action     = 2;
                }
                
                if($request){
                    if($action == 1){
                        $answer = [
                            'status' => true,
                            'msg'    => 'Periodo creado correctamente'
                        ];
                    }else{
                        $answer = [
                            'status' => true,
                            'msg'    => 'Periodo actualizado correctamente'
                        ];
                    }
                }else{
                    $answer = [
                        'status' => false,
                        'msg'    => 'Error al crear el periodo'
                    ];
                }
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }
    /*
     * Funcion para obtener todos los periodos
     */
    public function getPeriods($idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        // Determinar la condición basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);
        
        $sql = "
            SELECT
                *
            FROM 
                periods
            WHERE
                is_active = 1 ".$condition;
        
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }

    /*
     * Funcion para obtener informacion de un periodo por su ID
     */
    public function getPeriodsById($id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        // Determinar la condición basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);
        
        $sql = "
            SELECT
                *
            FROM
                periods
            WHERE
                id = ? AND is_active = 1 ".$condition;

        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /*
     * Funcion para actualizar informacion de un periodo
     */
    public function deletePeriodById($id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        // Determinar la condición basada en el valor de $_SESSION['role_id']
        $condition = $this->getSessionCondition($idr);
        
        $sql = "
            UPDATE
                periods
            SET
                is_active = 0
            WHERE
                id = ? ".$condition;
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        
        return $stmt->execute();
    }
    /*
     *  Funcion para actualizar la sede
     */
    public function updateAsignCampuse($id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            UPDATE
                periods
            SET
                idr = ?
            WHERE
                id = ?
        ";
        $sql    = $conectar->prepare($sql);
        $sql->bindValue(1, $idr);
        $sql->bindValue(2, $id);
        $result = $sql->execute();
        
        if($result){
            $answer = [
                'status'      => true,
                'msg'         => 'Registro actualizado correctamente'
            ];
        }else{
            $answer = [
                'status'  => false,
                'msg'     => 'Fallo con la actualizacion de la sede',
            ];
        }
        
        // Devolver el rol antiguo y el nuevo
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }
}
