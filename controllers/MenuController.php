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
                if(($_POST['role_id'] == 2 OR $_POST['role_id'] == 3 OR $_POST['role_id'] == 4 OR $_POST['role_id'] == 5) AND $_SESSION['role_id'] != 1){
                    $sub_array[] = '<span class="label label-success">'.$row['permission'].'</span>';
                }else{
                    $sub_array[] = '<button type="button" onCLick="deshabilitar('.$row['id'].')" id="'.$row['id'].'" class="btn btn-success btn-label btn-sm"><i fa fa-wrench"></i>'.$row['permission'].'</button>';
                }
            }else{
                if(($_POST['role_id'] == 2 OR $_POST['role_id'] == 3 OR $_POST['role_id'] == 4 OR $_POST['role_id'] == 5) AND $_SESSION['role_id'] != 1){
                    $sub_array[] = '<span class="label label-danger">'.$row['permission'].'</span>';
                }else{
                    $sub_array[] = '<button type="button" onCLick="habilitar('.$row['id'].')" id="'.$row['id'].'" class="btn btn-danger btn-label btn-sm"><i fa fa-wrench"></i>'.$row['permission'].'</button>';
                }
            }
            $data[]      = $sub_array;
            
        }
        
        $results = [
            "sEcho"                 => 1,
            "iTotalRecords"         => count($data),
            "iTotalDisplayRecords"  => count($data),
            "aaData"                => $data
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