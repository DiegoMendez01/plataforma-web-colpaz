<?php

require_once("../docs/Session.php");
require_once("../models/Zones.php");
require_once("../models/Campuses.php");

class ZoneController
{
    private $zoneModel;
    private $campuseModel;
    private $session;

    public function __construct()
    {
        $this->zoneModel    = new Zones();
        $this->campuseModel = new Campuses();
        $this->session      = Session::getInstance();
    }

    public function handleRequest()
    {
        $idr = $this->session->get('idr');

        switch($_GET['op'])
        {
            case 'createOrUpdate':
                if(empty($_POST['id'])){
                    $this->create($_POST['name'], $idr);
                }else{
                    $this->update($_POST['id'], $_POST['name'], $idr);
                }
                break;
            case 'index':
                $this->index($idr);
                break;
            case 'updateAsignCampus':
                $this->updateAssignedCampus($_POST['xid'], $_POST['idr']);
                break;
            case 'delete':
                if (isset($_POST['id'])) {
                    $this->delete($_POST['id'], $idr);
                }
                break;
            case 'show':
                if (isset($_POST['id'])) {
                    $this->show($_POST['id'], $idr);
                }
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
            $status = $this->zoneModel->insertZone($name, $idr);
            if($status){
                $answer = [
                    'status' => true,
                    'msg'    => 'Se ha creado correctamente la zona'
                ];
            }else{
                $answer = [
                    'status' => false,
                    'msg'    => 'Error al crear una zona y/o duplicada'
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
            $status = $this->zoneModel->updateZone($id, $name, $idr);
            if($status){
                $answer = [
                    'status' => true,
                    'msg'    => 'Se ha actualizado correctamente la zona'
                ];
            }else{
                $answer = [
                    'status' => false,
                    'msg'    => 'Error al actualizar la zona y/o duplicados'
                ];
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }

    private function index($idr)
    {
        $zones = $this->zoneModel->getZones($idr);
        $data  = [];

        foreach($zones as $zone){
            $campusData = $this->campuseModel->getCampuseById($zone['idr']);

            $subArray   = [];
            $subArray[] = $zone['name'];
            $subArray[] = '<a onClick="editCampus('.$zone['id'].')"; id="'.$zone['id'].'"><span class="label label-pill label-primary">'.$campusData['name'].'</span></a>';
            $subArray[] = $zone['created'];
            if($zone['is_active'] == 1){
                $subArray[] = '<span class="label label-success">Activo</span>';
            }
            $subArray[] = '<button type="button" onClick="editar('.$zone["id"].')"; id="'.$zone['id'].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
            $subArray[] = '<button type="button" onClick="eliminar('.$zone["id"].')"; id="'.$zone['id'].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
            $subArray[] = '<button type="button" onClick="ver('.$zone["id"].')"; id="'.$zone['id'].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
            
            $data[] = $subArray;
        }

        $results = [
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        ];

        echo json_encode($results);
    }

    private function updateAssignedCampus($xid, $idr) {
        $status = $this->zoneModel->updateAssignedCampus($xid, $idr);
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

    private function delete($id, $idr) {
        $this->zoneModel->deleteZoneById($id, $idr);
    }

    private function show($id, $idr) {
        $zone = $this->zoneModel->getZoneById($id, $idr);
        echo json_encode($zone);
    }
}

$controller = new ZoneController();
$controller->handleRequest();