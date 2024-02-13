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
        $content->InsertOrupdateContent($_POST['id'], $_POST['title'], $_POST['description'], $_POST['type'], $_POST['teacher_course_id'], $_FILES['file']);
        break;
    /*
     * Eliminar totalmente registros de contenidos existentes por su ID (eliminado logico).
     */
    case 'deleteContentById':
        if(isset($_POST['id'])){
            $content->deleteContentById($_POST['id']);
        }
        break;
}
?>
