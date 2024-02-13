<?php

class Roles extends Connect
{
    /*
     * Funcion para insertar/registrar un nuevo rol
     */
    public function updateOrInsertRole($id = null, $name, $functions)
    {
        if(empty($name) OR empty($functions)){
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
                    roles
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
                    'msg'    => 'El rol ya existe'
                ];
            }else{
                if(empty($id)){
                    $sqlInsert = "
                        INSERT INTO
                            roles (name, functions, created)
                        VALUES
                            (?, ?, now())
                    ";
                    
                    $stmtInsert = $conectar->prepare($sqlInsert);
                    $stmtInsert->bindValue(1, $name);
                    $stmtInsert->bindValue(2, $functions);
                    $request    = $stmtInsert->execute();
                    $action     = 1;
                }else{
                    $sqlUpdate = "
                        UPDATE
                            roles
                        SET
                            name      = ?,
                            functions = ?
                        WHERE
                            id = ?
                    ";
                    
                    $stmtUpdate = $conectar->prepare($sqlUpdate);
                    $stmtUpdate->bindValue(1, $name);
                    $stmtUpdate->bindValue(2, $functions);
                    $stmtUpdate->bindValue(3, $id);
                    $request    = $stmtUpdate->execute();
                    $action     = 2;
                }
                
                if($request){
                    if($action == 1){
                        $answer = [
                            'status' => true,
                            'msg'    => 'Rol creado correctamente'
                        ];
                    }else{
                        $answer = [
                            'status' => true,
                            'msg'    => 'Rol actualizado correctamente'
                        ];
                    }
                }else{
                    $answer = [
                        'status' => false,
                        'msg'    => 'Error al crear el rol'
                    ];
                }
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
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

