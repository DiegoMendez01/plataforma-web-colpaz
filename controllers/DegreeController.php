<?php

require_once("../models/Degrees.php");

class DegreeController
{
    private $degreeModel;

    public function __construct()
    {
        $this->degreeModel = new Degrees();
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
                if(empty($_POST['classroom_id'])){
                    $this->combo();
                }else{
                    $this->combo($_POST['classroom_id']);
                }
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
            $status = $this->degreeModel->createDegree($name);
            if($status){
                $answer = [
                    'status' => true,
                    'msg'    => 'Se ha creado correctamente el grado'
                ];
            }else{
                $answer = [
                    'status' => false,
                    'msg'    => 'Error al crear el grado y/o duplicada'
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
            $status = $this->degreeModel->updateDegree($id, $name);
            if($status){
                $answer = [
                    'status' => true,
                    'msg'    => 'Se ha actualizado correctamente el grado'
                ];
            }else{
                $answer = [
                    'status' => false,
                    'msg'    => 'Error al actualizar el grado y/o duplicada'
                ];
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }

    private function index()
    {
        $degrees = $this->degreeModel->getDegrees();
        $data    = [];

        foreach($degrees as $degree){
            $subArray      = [];
            $subArray[]    = $degree['name'];
            $subArray[]    = $degree['created'];
            if($degree['is_active'] == 1){
                $subArray[] = '<span class="label label-success">Activo</span>';
            }

            $subArray[] = '<button type="button" onClick="editar('.$degree["id"].')"; id="'.$degree['id'].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
            $subArray[] = '<button type="button" onClick="eliminar('.$degree["id"].')"; id="'.$degree['id'].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
            $subArray[] = '<button type="button" onClick="ver('.$degree["id"].')"; id="'.$degree['id'].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';

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
        $this->degreeModel->deleteDegreeById($id);
    }

    private function show($id)
    {
        $degree = $this->degreeModel->getDegreeById($id);
        echo json_encode($degree);
    }

    private function combo($classroom_id = null)
    {
        if(empty($classroom_id)){
            $degrees = $this->degreeModel->getDegrees();
        }else{
            $degrees = $this->degreeModel->getDegreesByClassroom($classroom_id);
        }
        if(is_array($degrees) == true AND count($degrees) > 0){
            $html = "";
            $html.= "<option value='0' selected>Seleccionar</option>";
            foreach($degrees as $degree){
                $html.= "<option value='".$degree['id']."'>".$degree['name']."</option>";
            }
            echo $html;
        }
    }
}

$controller = new DegreeController();
$controller->handleRequest();
