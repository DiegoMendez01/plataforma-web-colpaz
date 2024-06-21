<?php

require_once("../config/database.php");
require_once("../models/Assessments.php");

$assessment = new Assessments();

$idr        = $_SESSION['idr'];

switch($_GET['op'])
{
    /*
     * Insertar o actualizar el registro de un contenido de curso. Dependiendo si existe o no el contenido,
     * se tomara un flujo.
     */
    case 'insertOrUpdate':
        $assessment->insertOrUpdate($_POST['id'], $_POST['title'], $_POST['comment'], $_POST['percentage'], $_POST['content_id'], $_FILES['file'], $_POST['date_limit'], $idr);
        break;
}
?>
