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
        $course->InsertOrupdateCourse($_POST['id'], $_POST['name'], $_POST['description']);
        break;
    /*
     * Es para listar/obtener los cursos que existen registrados en el sistema con una condicion que este activo.
     * Ademas, de dibujar una tabla para mostrar los registros
     */
    case 'listCourse':
        $datos = $course->getCourses();
        $data  = [];
        foreach($datos as $row){
            $sub_array   = [];
            $sub_array[] = $row['name'];
            $sub_array[] = $row['description'];
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
     * Eliminar un usuario por medio de su identificador
     */
    case 'deleteCourseById':
        $course->deleteCourseById($_POST['id']);
        break;
    /*
     * Es para listar/obtener los cursos que existen registrados en el sistema.
     * Pero debe mostrar el curso por medio de su identificador unico
     */
    case 'listCourseById':
        $data = $course->getCourseById($_POST['id']);
        
        $output["id"]           = $data['id'];
        $output["name"]         = $data['name'];
        $output["description"]  = $data['description'];
        
        echo json_encode($output);
        break;
    /*
     * Listar para comboBox
     */
    case 'combo':
        $datos = $course->getCourses();
        if(is_array($datos) == true AND count($datos) > 0){
            $html = "";
            $html.= "<option selected></option>";
            foreach($datos as $row){
                $html.= "<option value='".$row['id']."'>".$row['name']."</option>";
            }
            echo $html;
        }
        break;
}
?>