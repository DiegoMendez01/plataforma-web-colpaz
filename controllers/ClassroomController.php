<?php

require_once("../config/database.php");
require_once("../models/Classrooms.php");
require_once("../models/Degrees.php");
require_once("../models/Campuses.php");

class ClassroomController
{
    private $classroomModel;
    private $degreeModel;
    private $campuseModel;

    public function __construct()
    {
        $this->classroomModel = new Classrooms();
        $this->degreeModel    = new Degrees();
        $this->campuseModel   = new Campuses();
    }

    public function handleRequest()
    {
        $idr = $_SESSION['idr'];
        switch($_GET['op'])
        {
            case "createOrUpdate":
                if(empty($_POST['id'])){
                    $this->create($_POST['name'], $_POST['degree_id'], $idr);
                }else{
                    $this->update($_POST['id'], $_POST['name'], $_POST['degree_id'], $idr);
                }
                break;
            case "index":
                $this->index($idr);
                break;
            case "delete":
                $this->delete($_POST['id'], $_POST['idr']);
                break;
            case "show":
                $this->show($_POST['id'], $idr);
                break;
            case "combo":
                if(empty($_POST['degree_id'])){
                    $this->combo($idr);
                }else{
                    $this->combo($idr, $_POST['degree_id']);
                }
                break;
            case "updateAsignCampus":
                $this->updateAssignedCampus($_POST['xid'], $_POST['idr']);
                break;
        }
    }

    private function create($name, $degree_id, $idr)
    {
        if(empty($name) OR empty($degree_id)){
            $answer = [
                'status' => false,
                'msg'    => 'Todos los campos son necesarios'
            ];
        }else{
            $status = $this->classroomModel->createClassroom($name, $degree_id, $idr);
            if($status){
                $answer = [
                    'status' => true,
                    'msg'    => 'Se ha creado correctamente el aula'
                ];
            }else{
                $answer = [
                    'status' => false,
                    'msg'    => 'Error al crear el aula y/o duplicada'
                ];
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }

    private function update($id, $name, $degree_id, $idr)
    {
        if(empty($name) OR empty($degree_id)){
            $answer = [
                'status' => false,
                'msg'    => 'Todos los campos son necesarios'
            ];
        }else{
            $status = $this->classroomModel->updateClassroom($id, $name, $degree_id, $idr);
            if($status){
                $answer = [
                    'status' => true,
                    'msg'    => 'Se ha actualizado correctamente el aula'
                ];
            }else{
                $answer = [
                    'status' => false,
                    'msg'    => 'Error al actualizar el aula y/o duplicada'
                ];
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }

    private function index($idr)
    {
        $classrooms = $this->classroomModel->getClassrooms($idr);
        $data       = [];

        foreach($classrooms as $classroom){

            $degreeData  = $this->degreeModel->getDegreeById($classroom['degree_id']);
            $campuseData = $this->campuseModel->getCampuseById($classroom['idr']);

            $subArray   = [];
            $subArray[] = $classroom['name'];
            $subArray[] = $degreeData['name'];
            $subArray[] =  '<a onClick="editCampuse('.$classroom['id'].')"; id="'.$classroom['id'].'"><span class="label label-pill label-primary">'.$campuseData['name'].'</span></a>';
            $subArray[] = $classroom['created'];
            if($classroom['is_active'] == 1){
                $subArray[] = '<span class="label label-success">Activo</span>';
            }
            
            $subArray[] = '<button type="button" onClick="editar('.$classroom["id"].')"; id="'.$classroom['id'].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
            $subArray[] = '<button type="button" onClick="eliminar('.$classroom["id"].')"; id="'.$classroom['id'].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
            $subArray[] = '<button type="button" onClick="ver('.$classroom["id"].')"; id="'.$classroom['id'].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
            
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

    private function delete($id, $idr)
    {
        $this->classroomModel->deleteClassroomById($id, $idr);
    }

    private function show($id, $idr)
    {
        $classroom = $this->classroomModel->getClassroomById($id, $idr);
        echo json_encode($classroom);
    }

    private function combo($idr, $degree_id = null)
    {
        if(empty($degree_id)){
            $classrooms = $this->classroomModel->getClassrooms($idr);
        }else{
            $classrooms = $this->classroomModel->getClassroomsByDegree($degree_id, $idr);
        }

        if (is_array($classrooms) && count($classrooms) > 0) {
            $html = "<option value='0' selected>Seleccionar</option>";
            foreach ($classrooms as $classroom) {
                $html .= "<option value='".$classroom['id']."'>".$classroom['name']."</option>";
            }
            echo $html;
        }
    }

    private function updateAssignedCampus($xid, $idr)
    {
        $status = $this->classroomModel->updateAssignedCampus($xid, $idr);
        if($status){
            $answer = [
                'status'      => true,
                'msg'         => 'Registro actualizado correctamente'
            ];
        }else{
            $answer = [
                'status'  => false,
                'msg'     => 'Fallo con la actualizacion de la sede',
            ];
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }
}

$controller = new ClassroomController();
$controller->handleRequest();
