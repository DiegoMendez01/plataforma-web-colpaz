<?php

require_once('../config/database.php');
require_once('../models/Menus.php');

$menu = new Menus();

switch($_GET['op'])
{
    case "listMenu":
        $datos = $menu->getMenusByRole($_POST['role_id']);
        $data  = [];
        foreach($datos as $row){
            
            $sub_array   = [];
            $sub_array[] = $row["name"];
            if($row["permission"] == "Si"){
                $sub_array[] = '<button type="button" onCLick="deshabilitar('.$row['id'].')" id="'.$row['id'].'" class="btn btn-success btn-label btn-sm"><i fa fa-wrench"></i>'.$row['permission'].'</button>';
            }else{
                $sub_array[] = '<button type="button" onCLick="habilitar('.$row['id'].')" id="'.$row['id'].'" class="btn btn-danger btn-label btn-sm"><i fa fa-wrench"></i>'.$row['permission'].'</button>';
            }
            $data[]      = $sub_array;
            
        }
        
        $results = [
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDIsplayRecords" => count($data),
            "aaData" => $data
        ];
        echo json_encode($results);
        break;
    case "menuEnable":
        $menu->updateMenuEnable($_POST['id']);
        break;
    case "menuDisabled":
        $menu->updateMenuDisabled($_POST['id']);
        break;
}

?>