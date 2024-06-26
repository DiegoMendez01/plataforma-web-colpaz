<?php

require_once("../docs/Session.php");
require_once("../models/Periods.php");
require_once("../models/Campuses.php");

class PeriodController
{
    private $periodModel;
    private $campuseModel;
    private $session;

    public function __construct()
    {
        $this->periodModel  = new Periods();
        $this->campuseModel = new Campuses();
        $this->session      = Session::getInstance();
    }

    public function handleRequest()
    {
        $idr = $this->session->get('idr');
        
        switch($_GET['op'])
        {
            case "createOrUpdate":
                if(empty($_POST['id'])){
                    $this->create($_POST['name'], $idr);
                }else{
                    $this->update($_POST['id'], $_POST['name'], $idr);
                }
                break;
            case "index":
                $this->index($idr);
                break;
            case "delete":
                $this->delete($_POST['id'], $idr);
                break;
            case "show":
                $this->show($_POST['id'], $idr);
                break;
            case "combo":
                $this->combo($idr);
                break;
            case "updateAsignCampus":
                $this->updateAssignedCampus($_POST['xid'], $_POST['idr']);
                break;
        }
    }

    private function create($name, $idr)
    {
        if(empty($name)){
            $answer = [
                'status' => false,
                'msg'    => 'Todos los campos son necesarios'
            ];
        }else{
            $status = $this->periodModel->createPeriod($name, $idr);
            if($status){
                $answer = [
                    'status' => true,
                    'msg'    => 'Se ha creado correctamente el periodo academico'
                ];
            }else{
                $answer = [
                    'status' => false,
                    'msg'    => 'Error al crear el periodo academico y/o duplicado'
                ];
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }

    private function update($id, $name, $idr)
    {
        if(empty($name)){
            $answer = [
                'status' => false,
                'msg'    => 'Todos los campos son necesarios'
            ];
        }else{
            $status = $this->periodModel->updatePeriod($id, $name, $idr);
            if($status){
                $answer = [
                    'status' => true,
                    'msg'    => 'Se ha actualizado correctamente el periodo academico'
                ];
            }else{
                $answer = [
                    'status' => false,
                    'msg'    => 'Error al actualizar el periodo academico y/o duplicado'
                ];
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }

    private function index($idr)
    {
        $periods = $this->periodModel->getPeriods($idr);
        $data    = [];

        foreach($periods as $period){
            $campuseData    = $this->campuseModel->getCampuseById($period['idr']);

            $subArray      = [];
            $subArray[]    = $period['name'];
            $subArray[]    =  '<a onClick="editCampuse('.$period['id'].')"; id="'.$period['id'].'"><span class="label label-pill label-primary">'.$campuseData['name'].'</span></a>';
            $subArray[]    = $period['created'];
            if($period['is_active'] == 1){
                $subArray[] = '<span class="label label-success">Activo</span>';
            }
            
            $subArray[] = '<button type="button" onClick="editar('.$period["id"].')"; id="'.$period['id'].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
            $subArray[] = '<button type="button" onClick="eliminar('.$period["id"].')"; id="'.$period['id'].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
            $subArray[] = '<button type="button" onClick="ver('.$period["id"].')"; id="'.$period['id'].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
            
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
        $this->periodModel->deletePeriodById($id, $idr);
    }

    private function show($id, $idr)
    {
        $period = $this->periodModel->getPeriodsById($id, $idr);
        echo json_encode($period);
    }

    private function combo($idr)
    {
        $periods = $this->periodModel->getPeriods($idr);
        if(is_array($periods) == true AND count($periods) > 0){
            $html = "";
            $html.= "<option value='0' selected>Seleccionar</option>";
            foreach($periods as $period){
                $html.= "<option value='".$period['id']."'>".$period['name']."</option>";
            }
            echo $html;
        }
    }

    private function updateAssignedCampus($xid, $idr)
    {
        $status = $this->periodModel->updateAssignedCampus($xid, $idr);
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

$controller = new PeriodController();
$controller->handleRequest();
