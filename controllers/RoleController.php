<?php

require_once("../config/database.php");
require_once("../models/Roles.php");
require_once("../models/Campuses.php");

class RoleController
{
    private $roleModel;
    private $campuseModel;

    public function __construct()
    {
        $this->roleModel    = new Roles();
        $this->campuseModel = new Campuses();
    }

    public function handleRequest()
    {
        $idr = $_SESSION['idr'];
        switch($_GET['op'])
        {
            case "createOrUpdate":
                if(empty($_POST['id'])){
                    $this->create($_POST['name'], $_POST['functions'], $idr);
                }else{
                    $this->update($_POST['id'], $_POST['name'], $_POST['functions'], $idr);
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

    private function create($name, $functions, $idr)
    {
        if(empty($name) OR empty($functions)){
            $answer = [
                'status' => false,
                'msg'    => 'Todos los campos son necesarios'
            ];
        }else{
            $status = $this->roleModel->insertRole($name, $functions, $idr);
            if($status){
                $answer = [
                    'status' => true,
                    'msg'    => 'Se ha creado correctamente el rol'
                ];
            }else{
                $answer = [
                    'status' => false,
                    'msg'    => 'Error al crear un rol y/o duplicada'
                ];
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }

    private function update($id, $name, $functions, $idr)
    {
        if(empty($name) OR empty($functions)){
            $answer = [
                'status' => false,
                'msg'    => 'Todos los campos son necesarios'
            ];
        }else{
            $status = $this->roleModel->updateRole($id, $name, $functions, $idr);
            if($status){
                $answer = [
                    'status' => true,
                    'msg'    => 'Se ha actualizado correctamente el rol'
                ];
            }else{
                $answer = [
                    'status' => false,
                    'msg'    => 'Error al actualizar el rol y/o duplicados'
                ];
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }

    private function index($idr)
    {
        $roles = $this->roleModel->getRoles($idr);
        $data  = [];
        foreach ($roles as $rol) {
            
            $campuseData    = $this->campuseModel->getCampuseById($rol['idr']);
            
            $subArray      = [];
            $subArray[]    = $rol['name'];
            $subArray[]    = $rol['functions'];
            $subArray[]    = $rol['created'];
            if($rol['is_active'] == 1){
                $subArray[] = '<span class="label label-success">Activo</span>';
            }
            if($rol['idr'] <> 1 OR $_SESSION['role_id'] == 1){
                $subArray[] = '<a onClick="editCampuse('.$rol['id'].')"; id="'.$rol['id'].'"><span class="label label-pill label-primary">'.$campuseData['name'].'</span></a>';
            }else{
                $subArray[]    = '<span class="label label-pill label-primary">'.$campuseData['name'].'</span>';
            }
            
            $subArray[] = '<button type="button" onClick="permiso('.$rol['id'].')"; id="'.$rol['id'].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-wrench"></i></button>';
            $subArray[] = '<button type="button" onClick="editar('.$rol["id"].')"; id="'.$rol['id'].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
            $subArray[] = '<button type="button" onClick="eliminar('.$rol["id"].')"; id="'.$rol['id'].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
            $subArray[] = '<button type="button" onClick="ver('.$rol["id"].')"; id="'.$rol['id'].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
            
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
        $this->roleModel->deleteRolesById($id, $idr);
    }

    private function show($id, $idr)
    {
        $rol = $this->roleModel->getRolesById($id, $idr);
        echo json_encode($rol);
    }

    private function combo($idr)
    {
        $roles = $this->roleModel->getRoles($idr);
        if(is_array($roles) == true AND count($roles) > 0){
            $html = "";
            $html.= "<option value='0' selected>Seleccionar</option>";
            foreach($roles as $rol){
                $html.= "<option value='".$rol['id']."'>".$rol['name']."</option>";
            }
            echo $html;
        }
    }

    private function updateAssignedCampus($xid, $idr)
    {
        $status = $this->roleModel->updateAssignedCampus($xid, $idr);
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

$controller = new RoleController();
$controller->handleRequest();