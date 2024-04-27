<?php

class menuRolesController
{
    public function view($id = null){
        header("Content-Type: application/json");
        
        if(empty($id)){
            $menu_roles = menuRoleModel::index("menu_roles");
            $arrayData = [
                "status" => 200,
                "message" => "Lista de menus roles " . count($menu_roles),
                "menuRoles" => []
            ];
            foreach($menu_roles as $value){
                $menuRoleDetails = [
                    "menu_id"                   => $value['menu_id'],
                    "role_id"                   => $value['role_id'],
                    "permission"                => $value['permission'],
                    "idr"                       => $value['idr'],
                    "created"                   => $value['created']
                ];
                $arrayData["menuRoles"][] = $menuRoleDetails;
            }
        }else{
            $menu_roles = menuRoleModel::menuRoleById("menu_roles", $id);
            
            if(empty($menu_roles)){
                $json = [
                    "status" => 400,
                    "message" => 'No se ha encontrado un menu por rol con el ID: '.$id
                ];
                echo json_encode($json, true);
                return;
            }
            $arrayData = [
                "status" => 200,
                "message" => "Menu Rol con ID: " . $id,
                "value" => [
                    "menu_id"                   => $menu_roles['menu_id'],
                    "role_id"                   => $menu_roles['role_id'],
                    "permission"                => $menu_roles['permission'],
                    "idr"                       => $menu_roles['idr'],
                    "created"                   => $menu_roles['created']
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
        
        $menu_role = menuRoleModel::create("menu_roles", $data);
        
        if($menu_role){
            $json = [
                "status" => 200,
                "message" => 'Se ha creado correctamente los menus roles'
            ];

        }else{
            $json = [
                "status" => 400,
                "message" => 'No se creo correctamente los menus roles'
            ];
        }
        echo json_encode($json, true);
        return;
    }
}
?>