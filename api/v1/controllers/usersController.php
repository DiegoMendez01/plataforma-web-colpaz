<?php

class usersController
{
    public function view(){
        $users = userModel::index("users");
        $arrayData = [
            "status" => 200,
            "message" => "Lista de usuarios " . count($users),
            "users" => []
        ];
        foreach($users as $key => $value){
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
        echo json_encode($arrayData, true);
        return;
    }
}
?>