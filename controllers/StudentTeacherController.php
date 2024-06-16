<?php
// Importa la clase del modelo
require_once("../config/database.php");
require_once("../models/TeacherCourses.php");
require_once("../models/Users.php");
require_once("../models/Periods.php");
require_once("../models/StudentTeachers.php");
require_once("../models/Courses.php");
require_once("../models/Classrooms.php");
require_once("../models/Campuses.php");

$teacherCourse  = new TeacherCourses();
$user           = new Users();
$period         = new Periods();
$course         = new Courses();
$classroom      = new Classrooms();
$studentTeacher = new StudentTeachers();
$campuse        = new Campuses();

$idr = $_SESSION['idr'];

switch($_GET['op'])
{
    /*
     * Insertar o actualizar el registro de un estudiante por profesor. Dependiendo si existe o no el estudiante por profesor,
     * se tomara un flujo.
     */
    case 'insertOrUpdate':
        $studentTeacher->insertOrUpdateStudentTeacher($_POST['id'], $_POST['user_id'], $_POST['teacher_course_id'], $_POST['period_id']);
        break;
    /*
     * Es para listar/obtener los estudiantes por profesor que existen registrados en el sistema con una condicion que este activo.
     * Ademas, de dibujar una tabla para mostrar los registros.
     */
    case 'listStudentTeachers':
        $datos = $studentTeacher->getStudentTeacher();
        $data  = [];
        foreach ($datos as $row) {
            $studentData           = $user->getUserById($row['user_id']);
            $teacherCourseData     = $teacherCourse->getTeacherCourseById($row['teacher_course_id']);
            $periodData            = $period->getPeriodsById($row['period_id']);
            $classroomData         = $classroom->getClassroomById($teacherCourseData['classroom_id'], $idr);
            $courseData            = $course->getCourseById($teacherCourseData['course_id'], $idr);
            $teacherData           = $user->getUserById($teacherCourseData['user_id']);
            $campuseData           = $campuse->getCampuseById($row['idr']);
            
            
            $sub_array      = [];
            $sub_array[]    = $studentData[0]['name'].' '.$studentData[0]['lastname'];
            $sub_array[]    = $teacherData[0]['name'].' '.$teacherData[0]['lastname'];
            $sub_array[]    = $courseData['name'];
            $sub_array[]    = $classroomData['name'];
            $sub_array[]    = $periodData['name'];
            $sub_array[]    =  '<a onClick="editCampuse('.$row['id'].')"; id="'.$row['id'].'"><span class="label label-pill label-primary">'.$campuseData['name'].'</span></a>';
            if($row['is_active'] == 1){
                $sub_array[] = '<span class="label label-success">Activo</span>';
            }
            
            $sub_array[] = '<button type="button" onClick="editar('.$row["id"].')"; id="'.$row['id'].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
            $sub_array[] = '<button type="button" onClick="eliminar('.$row["id"].')"; id="'.$row['id'].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
            $sub_array[] = '<button type="button" onClick="ver('.$row["id"].')"; id="'.$row['id'].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
            
            $data[] = $sub_array;
        }
        $results = [
            "sEcho"                 => 1,
            "iTotalRecords"         => count($data),
            "iTotalDisplayRecords"  => count($data),
            "aaData"                => $data
        ];
        echo json_encode($results);
        break;
    /*
     * Eliminar totalmente registros de estudiantes por profesor existentes por su ID (eliminado logico).
     */
    case 'deleteStudentTeacherById':
        if(isset($_POST['id'])){
            $studentTeacher->deleteStudentTeacherById($_POST['id']);
        }
        break;
    /*
     * Es para listar/obtener los estudiantes por profesor que existen registrados en el sistema.
     * Pero debe mostrar el estudiante por profesor por medio de su identificador unico
     */
    case 'listStudentTeacherById':
        $datos = $studentTeacher->getStudentTeacherById($_POST['id']);
        
        if(is_array($datos) == true AND count($datos)){
            foreach($datos as $row){
                $output["id"]                   = $row['id'];
                $output["user_id"]              = $row['user_id'];
                $output["teacher_course_id"]    = $row['teacher_course_id'];
                $output["period_id"]            = $row['period_id'];
                
            }
            echo json_encode($output);
        }
        break;
}
?>