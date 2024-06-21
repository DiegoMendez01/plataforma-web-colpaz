<?php

require_once('../config/database.php');
require_once('../models/Menus.php');

class MenuController
{
    private $menuModel;

    public function __construct()
    {
        $this->menuModel = new Menus();
    }

    public function handleRequest()
    {
        switch($_GET['op'])
        {
            case "index":
                $this->index($_POST['role_id']);
                break;
            case "menuEnable":
                $this->enable($_POST['id']);
                break;
            case "menuDisabled":
                $this->disabled($_POST['id']);
                break;
        }
    }

    private function index($role_id)
    {
        $menus = $this->menuModel->getMenusByRole($role_id);
        $data  = [];
        foreach($menus as $menu){
            $subArray   = [];
            $subArray[] = $menu["name"];
            if($menu["permission"] == "Si"){
                if(($role_id == 2 OR $role_id == 3 OR $role_id == 4 OR $role_id == 5) AND $_SESSION['role_id'] != 1){
                    $subArray[] = '<span class="label label-success">'.$menu['permission'].'</span>';
                }else{
                    $subArray[] = '<button type="button" onCLick="deshabilitar('.$menu['id'].')" id="'.$menu['id'].'" class="btn btn-success btn-label btn-sm"><i fa fa-wrench"></i>'.$menu['permission'].'</button>';
                }
            }else{
                if(($role_id == 2 OR $role_id == 3 OR $role_id == 4 OR $role_id == 5) AND $_SESSION['role_id'] != 1){
                    $subArray[] = '<span class="label label-danger">'.$menu['permission'].'</span>';
                }else{
                    $subArray[] = '<button type="button" onCLick="habilitar('.$menu['id'].')" id="'.$menu['id'].'" class="btn btn-danger btn-label btn-sm"><i fa fa-wrench"></i>'.$menu['permission'].'</button>';
                }
            }
            $data[] = $subArray;
        }
        $results = [
            "sEcho"                 => 1,
            "iTotalRecords"         => count($data),
            "iTotalDisplayRecords"  => count($data),
            "aaData"                => $data
        ];
        echo json_encode($results);
    }

    private function enable($id)
    {
        $this->menuModel->enabled($id);
    }

    private function disabled($id)
    {
        $this->menuModel->disabled($id);
    }
}

$controller = new MenuController();
$controller->handleRequest();