<?php
// Importa la clase del modelo
require_once("../config/connection.php");
require_once("../models/HeaderContents.php");

$headerContent = new HeaderContents();

switch($_GET['op'])
{
    /*
     * Insertar o actualizar el registro de un grado academico. Dependiendo si existe o no el grado,
     * se tomara un flujo.
     */
    case 'insertOrUpdate':
        $headerContent->insertOrUpdateHeaderContent($_POST['idHeader'], $_POST['teacher_course_id'], $_FILES['supplementary_file'], $_FILES['curriculum_file'], $_POST['header_video']);
        break;
    /*
     * Eliminar totalmente registros de contenidos existentes por su ID (eliminado logico).
     */
    case 'deleteContentById':
        if(isset($_POST['idHeader'])){
            $headerContent->deleteHeaderContentById($_POST['idHeader']);
        }
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
