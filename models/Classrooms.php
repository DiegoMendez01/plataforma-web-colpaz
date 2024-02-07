<?php

class Classrooms extends Connect
{
    /*
     * Funcion para insertar/registrar aulas academicas por medio de un formulario
     */
    public function InsertOrupdateClassroom($id = null, $name)
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
                    classrooms
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
                    'msg'    => 'El aula ya existe'
                ];
            }else{
                if(empty($id)){
                    $sqlInsert = "
                        INSERT INTO
                            classrooms (name, created)
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
                            classrooms
                        SET
                            name      = ?
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
                            'msg'    => 'Aula creada correctamente'
                        ];
                    }else{
                        $answer = [
                            'status' => true,
                            'msg'    => 'Aula actualizada correctamente'
                        ];
                    }
                }else{
                    $answer = [
                        'status' => false,
                        'msg'    => 'Error al crear el aula'
                    ];
                }
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }
    /*
     * Funcion para traer todos las aulas academicas registrados hasta el momento
     */
    public function getClassrooms()
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                * 
            FROM 
                classrooms
            WHERE
                is_active = 1
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
    /*
     * Funcion para actualizar registros de aulas academicas
     */
    public function updateClassroom($id, $name)
    {
        $conectar = parent::connection();
        parent::set_names();
    
        $sql = "
            UPDATE
                classrooms
            SET
                name = ?
            WHERE
                id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $id);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
    /*
     * Funcion para eliminar totalmente registros de aulas academicas existentes (eliminado logico)
     */
    public function deleteClassroomById($id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                classrooms
            SET
                is_active = 0
            WHERE
                id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
    /*
     * Funcion para traer un aula academica segun el ID
     */
    public function getClassroomById($id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                *
            FROM
                classrooms
            WHERE
                id = ?
        ";
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}