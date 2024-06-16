<?php 

require_once("../config/database.php");
require_once("../models/Courses.php");
require_once("../models/Campuses.php");

$course  = new Courses();
$campuse = new Campuses();

$idr = $_SESSION['idr'];

switch($_GET['op']){
    /*
     * Insertar o actualizar el registro de un curso. Dependiendo si existe o no el curso
     * se tomara un flujo
     */
    case 'insertOrUpdate':
        $course->InsertOrupdateCourse($_POST['id'], $_POST['name'], $_POST['description'], $idr);
        break;
    /*
     * Es para listar/obtener los cursos que existen registrados en el sistema con una condicion que este activo.
     * Ademas, de dibujar una tabla para mostrar los registros
     */
    case 'listCourse':
        $datos = $course->getCourses($idr);
        $data  = [];
        foreach($datos as $row){
            
            $campuseData = $campuse->getCampuseById($row['idr']);
            
            $sub_array   = [];
            $sub_array[] = $row['name'];
            $sub_array[] = $row['description'];
            $sub_array[] =  '<a onClick="editCampuse('.$row['id'].')"; id="'.$row['id'].'"><span class="label label-pill label-primary">'.$campuseData['name'].'</span></a>';
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
     * El caso que sirve para actualizar la sede
     */
    case "updateAsignCampuse":
        $course->updateAsignCampuse($_POST['xid'], $_POST['idr']);
        break;
    /*
     * Eliminar un usuario por medio de su identificador
     */
    case 'deleteCourseById':
        $course->deleteCourseById($_POST['id'], $idr);
        break;
    /*
     * Es para listar/obtener los cursos que existen registrados en el sistema.
     * Pero debe mostrar el curso por medio de su identificador unico
     */
    case 'listCourseById':
        $data = $course->getCourseById($_POST['id'], $idr);
        
        $output["id"]           = $data['id'];
        $output["name"]         = $data['name'];
        $output["description"]  = $data['description'];
        
        echo json_encode($output);
        break;
    /*
     * Listar para comboBox
     */
    case 'combo':
        $datos = $course->getCourses($idr);
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