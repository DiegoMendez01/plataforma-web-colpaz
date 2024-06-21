<?php 

require_once("../config/database.php");
require_once("../models/Courses.php");
require_once("../models/Campuses.php");

class CourseController
{
    private $courseModel;
    private $campuseModel;

    public function __construct()
    {
        $this->courseModel  = new Courses();
        $this->campuseModel = new Campuses();
    }

    public function handleRequest()
    {
        $idr = $_SESSION['idr'];
        switch($_GET['op'])
        {
            case 'createOrUpdate':
                if(empty($_POST['id'])){
                    $this->create($_POST['name'], $_POST['description'], $idr);
                }else{
                    $this->update($_POST['id'], $_POST['name'], $_POST['description'], $idr);
                }
                break;
            case 'index':
                $this->index($idr);
                break;
            case 'updateAsignCampus':
                $this->updateAssignedCampus($_POST['xid'], $_POST['idr']);
                break;
            case 'delete':
                $this->delete($_POST['id'], $idr);
                break;
            case 'show':
                $this->show($_POST['id'], $idr);
                break;
            case 'combo':
                $this->combo($idr);
                break;
        }
    }

    private function create($name, $description = null, $idr)
    {
        if(empty($name)){
            $answer = [
                'status' => false,
                'msg'    => 'Todos los campos son necesarios'
            ];
        }else{
            $status = $this->courseModel->insertCourse($name, $description, $idr);
            if($status){
                $answer = [
                    'status' => true,
                    'msg'    => 'Se ha creado correctamente el curso'
                ];
            }else{
                $answer = [
                    'status' => false,
                    'msg'    => 'Error al crear un curso y/o duplicada'
                ];
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }

    private function update($id, $name, $description = null, $idr)
    {
        if(empty($name)){
            $answer = [
                'status' => false,
                'msg'    => 'Todos los campos son necesarios'
            ];
        }else{
            $status = $this->courseModel->updateCourse($id, $name, $description, $idr);
            if($status){
                $answer = [
                    'status' => true,
                    'msg'    => 'Se ha actualizado correctamente el curso'
                ];
            }else{
                $answer = [
                    'status' => false,
                    'msg'    => 'Error al actualizar el curso y/o duplicados'
                ];
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }

    private function index($idr)
    {
        $courses = $this->courseModel->getCourses($idr);
        $data    = [];
        foreach($courses as $course){
            $campuseData = $this->campuseModel->getCampuseById($course['idr']);

            $subArray   = [];
            $subArray[] = $course['name'];
            $subArray[] = $course['description'];
            $subArray[] =  '<a onClick="editCampuse('.$course['id'].')"; id="'.$course['id'].'"><span class="label label-pill label-primary">'.$campuseData['name'].'</span></a>';
            if($course['is_active'] == 1){
                $subArray[] = '<span class="label label-success">Activo</span>';
            }
            
            $subArray[] = '<button type="button" onClick="editar('.$course["id"].')"; id="'.$course['id'].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
            $subArray[] = '<button type="button" onClick="eliminar('.$course["id"].')"; id="'.$course['id'].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
            $subArray[] = '<button type="button" onClick="ver('.$course["id"].')"; id="'.$course['id'].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
            
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

    private function updateAssignedCampus($xid, $idr)
    {
        $status = $this->courseModel->updateAssignedCampus($xid, $idr);
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

    private function delete($id, $idr)
    {
        $this->courseModel->deleteCourseById($id, $idr);
    }

    private function show($id, $idr)
    {
        $course = $this->courseModel->getCourseById($id, $idr);
        echo json_encode($course);
    }

    private function combo($idr)
    {
        $courses = $this->courseModel->getCourses($idr);
        if(is_array($courses) == true AND count($courses) > 0){
            $html = "";
            $html.= "<option value='0' selected>Seleccionar</option>";
            foreach($courses as $course){
                $html.= "<option value='".$course['id']."'>".$course['name']."</option>";
            }
            echo $html;
        }
    }
}

$controller = new CourseController();
$controller->handleRequest();