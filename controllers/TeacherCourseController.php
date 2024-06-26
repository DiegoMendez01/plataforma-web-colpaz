<?php

require_once("../config/database.php");
require_once("../models/TeacherCourses.php");
require_once("../models/Users.php");
require_once("../models/Courses.php");
require_once("../models/Periods.php");
require_once("../models/Classrooms.php");
require_once("../models/Degrees.php");
require_once("../models/Campuses.php");

class TeacherCourseController
{
    private $teacherCourseModel;
    private $userModel;
    private $courseModel;
    private $classroomModel;
    private $periodModel;
    private $degreeModel;
    private $campuseModel;

    public function __construct()
    {
        $this->teacherCourseModel = new TeacherCourses();
        $this->userModel          = new Users();
        $this->courseModel        = new Courses();
        $this->classroomModel     = new Classrooms();
        $this->periodModel        = new Periods();
        $this->degreeModel        = new Degrees();
        $this->campuseModel       = new Campuses();
    }

    public function handleRequest()
    {
        $idr = $_SESSION['idr'];

        switch($_GET['op'])
        {
            case "createOrUpdate":
                if(empty($_POST['id'])){
                    $this->create($_POST['user_id'], $_POST['course_id'], $_POST['classroom_id'], $_POST['period_id'], $_POST['degree_id'], $idr);
                }else{
                    $this->update($_POST['id'], $_POST['user_id'], $_POST['course_id'], $_POST['classroom_id'], $_POST['period_id'], $_POST['degree_id'], $idr);
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
            case "getTeacherCourses":
                $this->getTeacherCourses($idr);
                break;
            case "combo":
                $this->combo($idr);
                break;
        }
    }

    private function create($user_id, $course_id, $classroom_id, $period_id, $degree_id, $idr)
    {
        if(empty($user_id) OR empty($course_id) OR empty($classroom_id) OR empty($period_id) OR empty($degree_id)){
            $answer = [
                'status' => false,
                'msg'    => 'Todos los campos son necesarios'
            ];
        }else{
            $status = $this->teacherCourseModel->insertTeacherCourse($user_id, $course_id, $classroom_id, $period_id, $degree_id, $idr);
            if($status){
                $answer = [
                    'status' => true,
                    'msg'    => 'Curso Profesor creado correctamente'
                ];
            }else{
                $answer = [
                    'status' => false,
                    'msg'    => 'El grado, curso, materia y profesor existen, seleccione otro'
                ];
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }

    private function update($id, $user_id, $course_id, $classroom_id, $period_id, $degree_id, $idr)
    {
        if(empty($user_id) OR empty($course_id) OR empty($classroom_id) OR empty($period_id) OR empty($degree_id)){
            $answer = [
                'status' => false,
                'msg'    => 'Todos los campos son necesarios'
            ];
        }else{
            $status = $this->teacherCourseModel->updateTeacherCourse($id, $user_id, $course_id, $classroom_id, $period_id, $degree_id, $idr);
            if($status){
                $answer = [
                    'status' => true,
                    'msg'    => 'Curso Profesor actualizado correctamente'
                ];
            }else{
                $answer = [
                    'status' => false,
                    'msg'    => 'El grado, curso, materia y profesor existen, seleccione otro'
                ];
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }

    private function index($idr)
    {
        $teacherCourses = $this->teacherCourseModel->getTeacherCourses($idr);
        $data           = [];
        foreach ($teacherCourses as $teacherCourse) {
            $campuseData   = $this->campuseModel->getCampuseById($teacherCourse['idr']);
            
            $subArray      = [];
            $subArray[]    = $teacherCourse['nameCourse'];
            $subArray[]    = $teacherCourse['nameClassroom'];
            $subArray[]    = $teacherCourse['nameDegree'];
            $subArray[]    = $teacherCourse['namePeriod'];
            $subArray[]    = $teacherCourse['nameTeacher'].' '.$teacherCourse['lastname'];
            $subArray[]    =  '<a onClick="editCampuse('.$teacherCourse['id'].')"; id="'.$teacherCourse['id'].'"><span class="label label-pill label-primary">'.$campuseData['name'].'</span></a>';
            if($teacherCourse['is_active'] == 1){
                $subArray[] = '<span class="label label-success">Activo</span>';
            }
            
            $subArray[] = '<button type="button" onClick="editar('.$teacherCourse["id"].')"; id="'.$teacherCourse['id'].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
            $subArray[] = '<button type="button" onClick="eliminar('.$teacherCourse["id"].')"; id="'.$teacherCourse['id'].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
            $subArray[] = '<button type="button" onClick="ver('.$teacherCourse["id"].')"; id="'.$teacherCourse['id'].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
            
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
        $this->teacherCourseModel->deleteTeacherCourseById($id, $idr);
    }

    private function show($id, $idr)
    {
        $teacherCourse = $this->teacherCourseModel->getTeacherCourseById($id, $idr);
        echo json_encode($teacherCourse);
    }

    private function getTeacherCourses($idr)
    {
        $this->teacherCourseModel->getTeacherCoursesAllData($idr);
    }

    private function combo($idr)
    {
        $teacherCourses = $this->teacherCourseModel->getTeacherCourses($idr);
        if(is_array($teacherCourses) == true AND count($teacherCourses) > 0){
            $html = "";
            $html.= "<option value='0' selected>Seleccionar</option>";
            foreach($teacherCourses as $data){
                $html.= "<option value='".$data['id']."'>".$data['name']." | ".$data['nameCourse']." | ".$data['nameClassroom']."</option>";
            }
            echo $html;
        }
    }
}

$controller = new TeacherCourseController();
$controller->handleRequest();