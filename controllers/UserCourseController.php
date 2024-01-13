<?php
// Importa la clase del modelo
require_once("../config/connection.php");
require_once("../models/UserCourses.php");
require_once("../models/Users.php");
require_once("../models/Courses.php");

$userCourse = new UserCourses();
$user       = new Users();
$course     = new Courses();

switch($_GET['op'])
{
    /*
     * Insertar o actualizar el registro de un grado academico. Dependiendo si existe o no el grado,
     * se tomara un flujo.
     */
    case 'insertOrUpdate':
        if(empty($_POST['id'])){
            $userCourse->insertUserCourse($_POST['user_id'], $_POST['course_id']);
        } else {
            var_dump($_POST['user_id'], $_POST['course_id']);
            $userCourse->updateUserCourse($_POST['id'], $_POST['user_id'], $_POST['course_id']);
        }
        break;
        /*
         * Es para listar/obtener los grados academicos que existen registrados en el sistema con una condicion que este activo.
         * Ademas, de dibujar una tabla para mostrar los registros.
         */
    case 'listUserCourses':
        $datos = $userCourse->getUserCourses();
        
        foreach ($datos as $row) {
            $userData   = $user->getUserById($row['user_id']);
            $courseData = $course->getCourseById($row['course_id']);
            
            $sub_array      = [];
            $sub_array[]    = $courseData[0]['name'];
            $sub_array[]    = $userData[0]['name'].' '.$userData[0]['lastname'];
            $sub_array[]    = $row['created'];
            if($row['is_active'] == 1){
                $sub_array[] = 'Activo';
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
    case 'deleteUserCourseById':
        if(isset($_POST['id'])){
            $userCourse->deleteUserCourseById($_POST['id']);
        }
        break;
        /*
         * Es para listar/obtener los usuarios que existen registrados en el sistema.
         * Pero debe mostrar el usuario por medio de su identificador unico
         */
    case 'listUserCourseById':
        $datos = $userCourse->getUserCourseById($_POST['id']);
        
        if(is_array($datos) == true AND count($datos)){
            foreach($datos as $row){
                $output["id"]        = $row['id'];
                $output["user_id"]   = $row['user_id'];
                $output["course_id"] = $row['course_id'];
            }
            echo json_encode($output);
        }
        break;
    /*
     * Es para listar/obtener los usuarios que existen registrados en el sistema.
     */
    case 'listUsers':
        $datos = $userCourse->getUsers();
        echo json_encode($datos);
        break;
    /*
     * Es para listar/obtener los usuarios que existen registrados en el sistema.
     */
    case 'listCourses':
        $datos = $userCourse->getCourses();
        echo json_encode($datos);
        break;
}
?>