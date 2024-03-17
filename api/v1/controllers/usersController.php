<?php

class usersController
{
    public function view($id = null){
        header("Content-Type: application/json");
        
        if(empty($id)){
            $users = userModel::index("users");
            $arrayData = [
                "status" => 200,
                "message" => "Lista de usuarios " . count($users),
                "users" => []
            ];
            foreach($users as $value){
                $userDetails = [
                    "name"                      => $value['name'],
                    "lastname"                  => $value['lastname'],
                    "username"                  => $value['username'],
                    "identification_type_id"    => $value['identification_type_id'],
                    "identification"            => $value['identification'],
                    "password_hash"             => $value['password_hash'],
                    "email"                     => $value['email'],
                    "phone"                     => $value['phone'],
                    "phone2"                    => $value['phone2'],
                    "birthdate"                 => $value['birthdate'],
                    "sex"                       => $value['sex'],
                    "created"                   => $value['created'],
                    "role_id"                   => $value['role_id']
                ];
                $arrayData["users"][] = $userDetails;
            }
        }else{
            $user = userModel::userById("users", $id);
            
            if(empty($user)){
                $json = [
                    "status" => 400,
                    "message" => 'No se ha encontrado un usuario con el ID: '.$id
                ];
                echo json_encode($json, true);
                return;
            }
            $arrayData = [
                "status" => 200,
                "message" => "Usuario con ID: " . $id,
                "value" => [
                    "name"                      => $user['name'],
                    "lastname"                  => $user['lastname'],
                    "username"                  => $user['username'],
                    "identification_type_id"    => $user['identification_type_id'],
                    "identification"            => $user['identification'],
                    "password_hash"             => $user['password_hash'],
                    "email"                     => $user['email'],
                    "phone"                     => $user['phone'],
                    "phone2"                    => $user['phone2'],
                    "birthdate"                 => $user['birthdate'],
                    "sex"                       => $user['sex'],
                    "created"                   => $user['created'],
                    "role_id"                   => $user['role_id']
                ]
            ];
            
        }
        echo json_encode($arrayData, true);
        return;
    }
    /*
     * Crear un usuario
     */
    public function create($data)
    {
        header("Content-Type: application/json");
        
        $user = userModel::create("users", $data);
        
        if($user == 'create'){
            $json = [
                "status" => 200,
                "message" => 'Se ha creado correctamente el usuario'
            ];
        }else if($user == 'verifyFalse'){
            $json = [
                "status" => 400,
                "message" => 'Hay información duplicada que existe en la base de datos de un usuario'
            ];
        }else{
            $json = [
                "status" => 400,
                "message" => 'No se creo correctamente el usuario'
            ];
        }
        echo json_encode($json, true);
        return;
    }
}
?>