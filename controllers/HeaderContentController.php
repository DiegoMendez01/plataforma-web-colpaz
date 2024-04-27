<?php
// Importa la clase del modelo
require_once("../config/database.php");
require_once("../models/HeaderContents.php");
require_once("../models/TeacherCourses.php");
require_once("../models/Users.php");

$headerContent = new HeaderContents();
$teacherCourse = new TeacherCourses();
$user          = new Users();

switch($_GET['op'])
{
    /*
     * Insertar o actualizar el registro de una cabecera de contenido de un curso. Dependiendo si existe o no la cabecera,
     * se tomara un flujo.
     */
    case 'insertOrUpdate':
        $headerContent->insertOrUpdateHeaderContent($_POST['idHeader'], $_POST['teacher_course_id'], $_FILES['supplementary_file'], $_FILES['curriculum_file'], $_POST['header_video']);
        break;
    /*
     * Eliminar totalmente registros de cabeceras de contenidos existentes por su ID (eliminado logico).
     */
    case 'deleteHeaderContentById':
        if(isset($_POST['idHeader'])){
            $headerContent->deleteHeaderContentById($_POST['idHeader']);
        }
        break;
    /*
     * Es para listar/obtener las cabeceras de contenidos que existen registrados en el sistema con una condicion que este activo.
     * Ademas, de dibujar una tabla para mostrar los registros.
     */
    case 'listHeaderContent':
        $datos = $headerContent->getHeaderContents();
        $data  = [];
        foreach ($datos as $row) {
            
            $dataTeacherCourse = $teacherCourse->getTeacherCourseById($row['teacher_course_id']);
            $dataUser          = $user->getUserById($dataTeacherCourse['user_id']);
            
            $sub_array      = [];
            $sub_array[]    = $dataUser['name'].' '.$dataUser['lastname'];
            $sub_array[]    = $row['created'];
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
     * Es para listar/obtener los encabezados de contenidos de cursos que existen registrados en el sistema.
     */
    case 'listHeaderContentById':
        $data = $headerContent->getHeaderContentById($_POST['idHeader']);
        
        $output["id"]                 = $data['id'];
        $output["teacher_course_id"]  = $data['teacher_course_id'];
        $output["header_video"]       = $data['header_video'];
        
        echo json_encode($output);
        break;
}
?>
