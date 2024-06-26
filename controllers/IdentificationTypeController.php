<?php

require_once("../models/IdentificationTypes.php");

class IdentificationTypeController
{
    private $identificationTypeModel;

    public function __construct()
    {
        $this->identificationTypeModel = new IdentificationTypes();
    }

    public function handleRequest()
    {
        switch($_GET['op'])
        {
            case "createOrUpdate":
                if(empty($_POST['id'])){
                    $this->create($_POST['name']);
                }else{
                    $this->update($_POST['id'], $_POST['name']);
                }
                break;
            case "index":
                $this->index();
                break;
            case "delete":
                $this->delete($_POST['id']);
                break;
            case "show":
                $this->show($_POST['id']);
                break;
            case "combo":
                $this->combo();
                break;
        }
    }

    private function create($name)
    {
        if(empty($name)){
            $answer = [
                'status' => false,
                'msg'    => 'Todos los campos son necesarios'
            ];
        }else{
            $status = $this->identificationTypeModel->insertIdentificationType($name);
            if($status){
                $answer = [
                    'status' => true,
                    'msg'    => 'Se ha creado correctamente el tipo de identificacion'
                ];
            }else{
                $answer = [
                    'status' => false,
                    'msg'    => 'Error al crear un tipo de identificacion y/o duplicada'
                ];
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }

    private function update($id, $name)
    {
        if(empty($name)){
            $answer = [
                'status' => false,
                'msg'    => 'Todos los campos son necesarios'
            ];
        }else{
            $status = $this->identificationTypeModel->updateIdentificationType($id, $name);
            if($status){
                $answer = [
                    'status' => true,
                    'msg'    => 'Se ha actualizado correctamente el tipo de identificacion'
                ];
            }else{
                $answer = [
                    'status' => false,
                    'msg'    => 'Error al actualizar el tipo de identificacion y/o duplicados'
                ];
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }

    private function index()
    {
        $identificationTypes = $this->identificationTypeModel->getIdentificationTypes();
        $data                = [];

        foreach($identificationTypes as $identificationType){
            $subArray      = [];
            $subArray[]    = $identificationType['name'];
            $subArray[]    = $identificationType['created'];
            if($identificationType['is_active'] == 1){
                $subArray[] = '<span class="label label-success">Activo</span>';
            }
            
            $subArray[] = '<button type="button" onClick="editar('.$identificationType["id"].')"; id="'.$identificationType['id'].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
            $subArray[] = '<button type="button" onClick="eliminar('.$identificationType["id"].')"; id="'.$identificationType['id'].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
            $subArray[] = '<button type="button" onClick="ver('.$identificationType["id"].')"; id="'.$identificationType['id'].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
            
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

    private function delete($id)
    {
        $this->identificationTypeModel->deleteIdentificationTypeById($id);
    }

    private function show($id)
    {
        $identificationType = $this->identificationTypeModel->getIdentificationTypeById($id);
        echo json_encode($identificationType);
    }

    private function combo()
    {

    }
}

$controller = new IdentificationTypeController();
$controller->handleRequest();