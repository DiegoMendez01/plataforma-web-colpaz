<?php 

require_once("../config/connection.php");
require_once("../models/Courses.php");

$course = new Courses();

switch($_GET['op']){
    /*
     * Insertar o actualizar el registro de un curso. Dependiendo si existe o no el curso
     * se tomara un flujo
     */
    case 'insertOrUpdate':
        if(empty($_POST['id'])){
            $course->insertCourse($_POST['name'], $_POST['description']);
        }else{
            $course->updateCourseById($_POST['id'], $_POST['name'], $_POST['description']);
        }
        break;
    /*
     * Es para listar/obtener los cursos que existen registrados en el sistema con una condicion que este activo.
     * Ademas, de dibujar una tabla para mostrar los registros
     */
    case 'listCourse':
        $datos = $course->getCourses();
        foreach($datos as $row){
            $sub_array   = [];
            $sub_array[] = $row['name'];
            $sub_array[] = $row['description'];
            $sub_array[] = $row['created'];
            
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
     * Eliminar un usuario por medio de su identificador
     */
    case 'deleteCourseById':
        $course->deleteCourseById($_POST['id']);
        break;
    /*
     * Es para listar/obtener los cursos que existen registrados en el sistema.
     * Pero debe mostrar el usuario por medio de su identificador unico
     */
    case 'listCourseById':
        $datos = $course->getCourseById($_POST['id']);
        
        if(is_array($datos) == true AND count($datos)){
            foreach($datos as $row){
                $output["id"]                       = $row['id'];
                $output["name"]                     = $row['name'];
                $output["description"]                 = $row['description'];
            }
            echo json_encode($output);
        }
        break;
}
?>