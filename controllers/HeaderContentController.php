<?php

require_once("../config/database.php");
require_once("../models/HeaderContents.php");
require_once("../models/TeacherCourses.php");
require_once("../models/Users.php");

class HeaderContentController
{
    private $headerContentModel;
    private $teacherCourseModel;
    private $userModel;

    public function __construct()
    {
        $this->headerContentModel = new HeaderContents();
        $this->teacherCourseModel = new TeacherCourses();
        $this->userModel          = new Users();
    }

    public function handleRequest()
    {
        $idr = $_SESSION['idr'];
        switch($_GET['op'])
        {
            case "createOrUpdate":
                if(empty($_POST['idHeader'])){
                    $this->create($_POST['teacher_course_id'], $_FILES['supplementary_file'], $_FILES['curriculum_file'], $_POST['header_video'], $idr);
                }else{
                    $this->update($_POST['idHeader'], $_POST['teacher_course_id'], $_FILES['supplementary_file'], $_FILES['curriculum_file'], $_POST['header_video'], $idr);
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
        }
    }

    private function create($teacher_course_id, $supplementary_file, $curriculum_file, $header_video, $idr)
    {
        if(empty($supplementary_file) OR empty($teacher_course_id) OR empty($curriculum_file)){
            $answer = [
                'status' => false,
                'msg'    => 'Todos los campos son necesarios'
            ];
        }else{
            // Files
            $material      = $_FILES['supplementary_file']['name'];
            $url_temp      = $_FILES['supplementary_file']['tmp_name'];
            
            $dir         = '../docs/contents/'.rand(1000, 10000);
            if(!file_exists($dir)){
                mkdir($dir, 0777, true);
            }
            
            $destiny     = $dir.'/'.$material;
            
            // Files
            $material2      = $_FILES['curriculum_file']['name'];
            $url_temp2      = $_FILES['curriculum_file']['tmp_name'];
            
            $dir2         = '../docs/contents/'.rand(1000, 10000);
            if(!file_exists($dir2)){
                mkdir($dir2, 0777, true);
            }
            
            $destiny2     = $dir2.'/'.$material2;

            if($_FILES['curriculum_file']['size'] > 15000000 OR $_FILES['supplementary_file']['size'] > 15000000){
                $answer = [
                    'status' => false,
                    'msg'    => 'Solo se permiten archivos hasta 15MB'
                ];
            }else{
                $status = $this->headerContentModel->createHeaderContent($teacher_course_id, $supplementary_file, $curriculum_file, $header_video, $destiny, $destiny2, $url_temp, $url_temp2, $idr);
                if($status){
                    $answer = [
                        'status' => true,
                        'msg'    => 'Se ha creado correctamente la cabecera del contenido'
                    ];
                }
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }

    private function update($id, $teacher_course_id, $supplementary_file, $curriculum_file, $header_video, $idr)
    {
        if(empty($supplementary_file) OR empty($teacher_course_id) OR empty($curriculum_file)){
            $answer = [
                'status' => false,
                'msg'    => 'Todos los campos son necesarios'
            ];
        }else{
            // Files
            $material      = $_FILES['supplementary_file']['name'];
            $url_temp      = $_FILES['supplementary_file']['tmp_name'];
            
            $dir         = '../docs/contents/'.rand(1000, 10000);
            if(!file_exists($dir)){
                mkdir($dir, 0777, true);
            }
            
            $destiny     = $dir.'/'.$material;
            
            // Files
            $material2      = $_FILES['curriculum_file']['name'];
            $url_temp2      = $_FILES['curriculum_file']['tmp_name'];
            
            $dir2         = '../docs/contents/'.rand(1000, 10000);
            if(!file_exists($dir2)){
                mkdir($dir2, 0777, true);
            }
            
            $destiny2     = $dir2.'/'.$material2;

            if($_FILES['curriculum_file']['size'] > 15000000 OR $_FILES['supplementary_file']['size'] > 15000000){
                $answer = [
                    'status' => false,
                    'msg'    => 'Solo se permiten archivos hasta 15MB'
                ];
            }else{
                $status = $this->headerContentModel->updateHeaderContent($id, $teacher_course_id, $supplementary_file, $curriculum_file, $header_video, $destiny, $destiny2, $url_temp, $url_temp2, $idr);
                if($status){
                    $answer = [
                        'status' => true,
                        'msg'    => 'Se ha actualizado correctamente la cabecera del contenido'
                    ];
                }
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }

    private function index($idr)
    {
        $headerContents = $this->headerContentModel->getHeaderContents($idr);
        $data           = [];

        foreach($headerContents as $headerContent){
            $dataTeacherCourse = $this->teacherCourseModel->getTeacherCourseById($headerContent['teacher_course_id'], $idr);
            $dataUser          = $this->userModel->getUserById($dataTeacherCourse['user_id']);
            
            $subArray      = [];
            $subArray[]    = $dataUser['name'].' '.$dataUser['lastname'];
            $subArray[]    = $headerContent['created'];
            if($headerContent['is_active'] == 1){
                $sub_array[] = '<span class="label label-success">Activo</span>';
            }
            
            $subArray[] = '<button type="button" onClick="editar('.$headerContent["id"].')"; id="'.$headerContent['id'].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
            $subArray[] = '<button type="button" onClick="eliminar('.$headerContent["id"].')"; id="'.$headerContent['id'].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
            $subArray[] = '<button type="button" onClick="ver('.$headerContent["id"].')"; id="'.$headerContent['id'].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
            
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
        $this->headerContentModel->deleteHeaderContentById($id, $idr);
    }

    private function show($id, $idr)
    {
        $headerContent = $this->headerContentModel->getHeaderContentById($id, $idr);
        echo json_encode($headerContent);
    }
}

$controller = new HeaderContentController();
$controller->handleRequest();
