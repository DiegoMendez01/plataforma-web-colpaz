<?php

require_once("../config/database.php");
require_once("../models/Campuses.php");

class CampuseController
{
    private $campuseModel;

    public function __construct()
    {
        $this->campuseModel = new Campuses();
    }

    public function handleRequest()
    {
        switch($_GET['op'])
        {
            case "createOrUpdate":
                if(empty($_POST['idr'])){
                    $this->create($_POST['name'], $_POST['description']);
                }else{
                    $this->update($_POST['idr'], $_POST['name'], $_POST['description']);
                }
                break;
            case "index":
                $this->index();
                break;
            case "delete":
                $this->delete($_POST['idr']);
                break;
            case "show":
                $this->show($_POST['idr']);
                break;
            case "combo":
                $this->combo();
                break;
        }
    }

    private function create($name, $description)
    {
        if(empty($name) OR empty($description)){
            $answer = [
                'status' => false,
                'msg'    => 'Todos los campos son necesarios'
            ];
        }else{
            $status = $this->campuseModel->createCampuse($name, $description);
            if($status){
                $answer = [
                    'status' => true,
                    'msg'    => 'Se ha creado correctamente la sede'
                ];
            }else{
                $answer = [
                    'status' => false,
                    'msg'    => 'Error al crear la sede y/o duplicada'
                ];
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }

    private function update($idr, $name, $description)
    {
        if(empty($name) OR empty($description)){
            $answer = [
                'status' => false,
                'msg'    => 'Todos los campos son necesarios'
            ];
        }else{
            $status = $this->campuseModel->updateCampuse($idr, $name, $description);
            if($status){
                $answer = [
                    'status' => true,
                    'msg'    => 'Se ha actualizado correctamente la sede'
                ];
            }else{
                $answer = [
                    'status' => false,
                    'msg'    => 'Error al actualizar la sede y/o duplicados'
                ];
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }

    private function index()
    {
        $campuses = $this->campuseModel->getCampuses();
        $data     = [];

        foreach($campuses as $campus){
            $subArray   = [];
            $subArray[] = $campus['name'];
            $subArray[] = $campus['created'];
            if($campus['is_active'] == 1){
                $subArray[] = '<span class="label label-success">Activo</span>';
            }
            
            $subArray[] = '<button type="button" onClick="editar('.$campus["idr"].')"; id="'.$campus['idr'].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
            $subArray[] = '<button type="button" onClick="eliminar('.$campus["idr"].')"; id="'.$campus['idr'].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
            $subArray[] = '<button type="button" onClick="ver('.$campus["idr"].')"; id="'.$campus['idr'].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
            
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

    private function delete($idr)
    {
        $this->campuseModel->deleteCampuseById($idr);
    }

    private function show($idr)
    {
        $campuse = $this->campuseModel->getCampuseById($idr);
        echo json_encode($campuse);
    }

    private function combo()
    {
        $campuses = $this->campuseModel->getCampuses();
        if(is_array($campuses) == true AND count($campuses) > 0){
            $html = "";
            $html.= "<option value='0' selected>Seleccionar</option>";
            foreach($campuses as $campuse){
                $html.= "<option value='".$campuse['idr']."'>".$campuse['name']."</option>";
            }
            echo $html;
        }
    }
}

$controller = new CampuseController();
$controller->handleRequest();
