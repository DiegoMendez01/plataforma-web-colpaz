<?php

require_once("../config/database.php");
require_once("../models/TeacherCourses.php");
require_once("../models/Users.php");
require_once("../models/Periods.php");
require_once("../models/StudentTeachers.php");
require_once("../models/Courses.php");
require_once("../models/Classrooms.php");
require_once("../models/Campuses.php");

class StudentTeacherController
{
    private $teacherCourseModel;
    private $userModel;
    private $periodModel;
    private $courseModel;
    private $classroomModel;
    private $studentTeacherModel;
    private $campuseModel;

    public function __construct()
    {
        $this->teacherCourseModel   = new TeacherCourses();
        $this->userModel            = new Users();
        $this->periodModel          = new Periods();
        $this->courseModel          = new Courses();
        $this->classroomModel       = new Classrooms();
        $this->studentTeacherModel  = new StudentTeachers();
        $this->campuseModel         = new Campuses();
    }

    public function handleRequest()
    {
        $idr = $_SESSION['idr'];

        switch($_GET['op'])
        {
            case "createOrUpdate":
                if(empty($_POST['id'])){
                    $this->create($_POST['user_id'], $_POST['teacher_course_id'], $_POST['period_id'], $idr);
                }else{
                    $this->update($_POST['id'], $_POST['user_id'], $_POST['teacher_course_id'], $_POST['period_id'], $idr);
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

    private function create($user_id, $teacher_course_id, $period_id, $idr)
    {
        if(empty($user_id) OR empty($teacher_course_id) OR empty($period_id)){
            $answer = [
                'status' => false,
                'msg'    => 'Todos los campos son necesarios'
            ];
        }else{
            $status = $this->studentTeacherModel->insertStudentTeacher($user_id, $teacher_course_id, $period_id, $idr);
            if($status){
                $answer = [
                    'status' => true,
                    'msg'    => 'Se ha creado correctamente el estudiante al curso'
                ];
            }else{
                $answer = [
                    'status' => false,
                    'msg'    => 'El grado, profesor materia y periodo existen, seleccione otro'
                ];
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }

    private function update($id, $user_id, $teacher_course_id, $period_id, $idr)
    {
        if(empty($user_id) OR empty($teacher_course_id) OR empty($period_id)){
            $answer = [
                'status' => false,
                'msg'    => 'Todos los campos son necesarios'
            ];
        }else{
            $status = $this->studentTeacherModel->updateStudentTeacher($id, $user_id, $teacher_course_id, $period_id, $idr);
            if($status){
                $answer = [
                    'status' => true,
                    'msg'    => 'Se ha actualizado correctamente el estudiante al curso'
                ];
            }else{
                $answer = [
                    'status' => false,
                    'msg'    => 'El grado, profesor materia y periodo existen, seleccione otro'
                ];
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }

    private function index($idr)
    {
        $studentTeachers = $this->studentTeacherModel->getStudentTeachers($idr);
        $data  = [];

        foreach ($studentTeachers as $studentTeacher) {
            $studentData           = $this->userModel->getUserById($studentTeacher['user_id']);
            $teacherCourseData     = $this->teacherCourseModel->getTeacherCourseById($studentTeacher['teacher_course_id'], $idr);
            $periodData            = $this->periodModel->getPeriodsById($studentTeacher['period_id'], $idr);
            $classroomData         = $this->classroomModel->getClassroomById($teacherCourseData['classroom_id'], $idr);
            $courseData            = $this->courseModel->getCourseById($teacherCourseData['course_id'], $idr);
            $teacherData           = $this->userModel->getUserById($teacherCourseData['user_id']);
            $campuseData           = $this->campuseModel->getCampuseById($studentTeacher['idr']);
            
            
            $sub_array      = [];
            $sub_array[]    = $studentData['name'].' '.$studentData['lastname'];
            $sub_array[]    = $teacherData['name'].' '.$teacherData['lastname'];
            $sub_array[]    = $courseData['name'];
            $sub_array[]    = $classroomData['name'];
            $sub_array[]    = $periodData['name'];
            $sub_array[]    =  '<a onClick="editCampuse('.$studentTeacher['id'].')"; id="'.$studentTeacher['id'].'"><span class="label label-pill label-primary">'.$campuseData['name'].'</span></a>';
            if($studentTeacher['is_active'] == 1){
                $sub_array[] = '<span class="label label-success">Activo</span>';
            }
            
            $sub_array[] = '<button type="button" onClick="editar('.$studentTeacher["id"].')"; id="'.$studentTeacher['id'].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
            $sub_array[] = '<button type="button" onClick="eliminar('.$studentTeacher["id"].')"; id="'.$studentTeacher['id'].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
            $sub_array[] = '<button type="button" onClick="ver('.$studentTeacher["id"].')"; id="'.$studentTeacher['id'].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
            
            $data[] = $sub_array;
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
        $this->studentTeacherModel->deleteStudentTeacherById($id, $idr);
    }

    private function show($id, $idr)
    {
        $studentTeacher = $this->studentTeacherModel->getStudentTeacherById($id, $idr);
        echo json_encode($studentTeacher);
    }
}

$controller = new StudentTeacherController();
$controller->handleRequest();