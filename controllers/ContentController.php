<?php
// Importa la clase del modelo
require_once("../config/connection.php");
require_once("../models/Contents.php");

$content = new Contents();

switch($_GET['op'])
{
    /*
     * Insertar o actualizar el registro de un grado academico. Dependiendo si existe o no el grado,
     * se tomara un flujo.
     */
    case 'insertOrUpdate':
        $content->InsertOrupdateContent($_POST['id'], $_POST['title'], $_POST['description'], $_POST['type'], $_POST['teacher_course_id'], $_FILES['file'], $_POST['video']);
        break;
    /*
     * Eliminar totalmente registros de contenidos existentes por su ID (eliminado logico).
     */
    case 'deleteContentById':
        if(isset($_POST['id'])){
            $content->deleteContentById($_POST['id']);
        }
        break;
    /*
     * Es para listar/obtener los contenidos de cursos que existen registrados en el sistema.
     */
    case 'listContentById':
        $data = $content->getContentById($_POST['id']);
        
        $output["id"]                = $data['id'];
        $output["title"]             = $data['title'];
        $output["description"]       = $data['description'];
        $output["type"]              = $data['type'];
        $output["video"]             = $data['video'];
        $output["teacher_course_id"] = $data['teacher_course_id'];
        
        echo json_encode($output);
        break;
}
?>
