<?php
// Importa la clase del modelo
require_once("../config/connection.php");
require_once("../models/TeacherCourses.php");
require_once("../models/Users.php");
require_once("../models/Periods.php");
require_once("../models/StudentTeachers.php");


$teacherCourse = new TeacherCourses();
$user          = new Users();
$period        = new Periods();
$studentTeacher = new StudentTeachers();



switch($_GET['op'])
{
    /*
     * Insertar o actualizar el registro de un grado academico. Dependiendo si existe o no el grado,
     * se tomara un flujo.
     */
    case 'insertOrUpdate':
        if(empty($_POST['id'])){
            $studentTeacher->insertStudentTeacher($_POST['user_id'], $_POST['teacher_course_id'], $_POST['period_id']);
        } else {
            $studentTeacher->updateStudentTeacher($_POST['id'], $_POST['user_id'], $_POST['teacher_course_id'], $_POST['period_id']);
        }
        break;
    /*
     * Es para listar/obtener los grados academicos que existen registrados en el sistema con una condicion que este activo.
     * Ademas, de dibujar una tabla para mostrar los registros.
     */
    case 'listStudentTeachers':
        $datos = $studentTeacher->getStudentTeacher();
        $data  = [];
        foreach ($datos as $row) {
            $userData      = $user->getUserById($row['user_id']);
            $studentTeacherData    = $studentTeacher->getStudentTeacherById($row['teacher_course_id']);
            $periodData    = $period->getPeriodsById($row['period_id']);
            
            
            $sub_array      = [];
            $sub_array[]    = $courseData[0]['name'];
            $sub_array[]    = $studentteacherData[0]['name'];
            $sub_array[]    = $periodData[0]['name'];
            $sub_array[]    = $userData[0]['name'].' '.$userData[0]['lastname'];
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
     * Eliminar totalmente registros de grados academicos existentes por su ID (eliminado logico).
     */
    case 'deleteStudentTeacherById':
        if(isset($_POST['id'])){
            $studentTeacher->deleteStudentTeacherById($_POST['id']);
        }
        break;
    /*
     * Es para listar/obtener los usuarios que existen registrados en el sistema.
     * Pero debe mostrar el usuario por medio de su identificador unico
     */
    case 'listStudentTeacherById':
        $datos = $studentTeacher->getTStudentTeacherById($_POST['id']);
        
        if(is_array($datos) == true AND count($datos)){
            foreach($datos as $row){
                $output["id"]           = $row['id'];
                $output["user_id"]      = $row['user_id'];
                $output["teacher_course_id"]    = $row['teacher_course_id'];
                $output["period_id"]    = $row['period_id'];
                
            }
            echo json_encode($output);
        }
        break;
}
?>