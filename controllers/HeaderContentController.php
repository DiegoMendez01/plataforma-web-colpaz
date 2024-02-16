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
        $headerContent->insertOrUpdateHeaderContent($_POST['id'], $_POST['teacher_course_id'], $_FILES['supplementary_file'], $_FILES['curriculum_file'], $_POST['header_video']);
        break;
    /*
     * Eliminar totalmente registros de contenidos existentes por su ID (eliminado logico).
     */
    case 'deleteContentById':
        if(isset($_POST['id'])){
            $headerContent->deleteHeaderContentById($_POST['id']);
        }
        break;
}
?>
