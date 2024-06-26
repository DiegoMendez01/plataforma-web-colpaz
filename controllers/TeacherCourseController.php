<?php
// Importa la clase del modelo
require_once("../config/database.php");
require_once("../models/TeacherCourses.php");
require_once("../models/Users.php");
require_once("../models/Courses.php");
require_once("../models/Periods.php");
require_once("../models/Classrooms.php");
require_once("../models/Degrees.php");
require_once("../models/Campuses.php");

$teacherCourse = new TeacherCourses();
$user          = new Users();
$course        = new Courses();
$classroom     = new Classrooms();
$period        = new Periods();
$degree        = new Degrees();
$campuse       = new Campuses();

$idr = $_SESSION['idr'];

switch($_GET['op'])
{
    /*
     * Insertar o actualizar el registro de un curso por profesor. Dependiendo si existe o no el curso por profesor,
     * se tomara un flujo.
     */
    case 'insertOrUpdate':
        $teacherCourse->insertOrUpdateTeacherCourse($_POST['id'], $_POST['user_id'], $_POST['course_id'], $_POST['classroom_id'], $_POST['period_id'], $_POST['degree_id'], $idr);
        break;
    /*
     * Es para listar/obtener los cursos por profesor que existen registrados en el sistema con una condicion que este activo.
     * Ademas, de dibujar una tabla para mostrar los registros.
     */
    case 'listTeacherCourses':
        $datos = $teacherCourse->getTeacherCourses($idr);
        $data  = [];
        foreach ($datos as $row) {
            $userData      = $user->getUserById($row['user_id']);
            $courseData    = $course->getCourseById($row['course_id'], $idr);
            $classroomData = $classroom->getClassroomById($row['classroom_id'], $idr);
            $periodData    = $period->getPeriodsById($row['period_id'], $idr);
            $degreeData    = $degree->getDegreeById($row['degree_id']);
            $campuseData   = $campuse->getCampuseById($row['idr']);
            
            $sub_array      = [];
            $sub_array[]    = $courseData['name'];
            $sub_array[]    = $classroomData['name'];
            $sub_array[]    = $degreeData['name'];
            $sub_array[]    = $periodData['name'];
            $sub_array[]    = $userData['name'].' '.$userData['lastname'];
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
     * Eliminar totalmente registros de cursos por profesor existentes por su ID (eliminado logico).
     */
    case 'deleteTeacherCourseById':
        if(isset($_POST['id'])){
            $teacherCourse->deleteTeacherCourseById($_POST['id'], $idr);
        }
        break;
    /*
     * Es para listar/obtener los cursos por profesor que existen registrados en el sistema.
     * Pero debe mostrar el curso por profesor por medio de su identificador unico
     */
    case 'listTeacherCourseById':
        $datos = $teacherCourse->getTeacherCourseById($_POST['id'], $idr);
        echo json_encode($datos);
        break;
    /*
     * Es para listar/obtener los docentes por cursos con su otra data anexada que existen registrados en el sistema.
     */
    case 'getTeacherCourses':
        $teacherCourse->getTeacherCoursesAllData($idr);
        break;
}
?>