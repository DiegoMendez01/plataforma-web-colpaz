<?php
// Importa la clase del modelo
require_once("../config/connection.php");
require_once("../models/Grades.php");

$gradesModel = new Grades();

switch($_GET['op']){
    /*
     * Insertar o actualizar el registro de un grado académico. Dependiendo si existe o no el grado,
     * se tomará un flujo.
     */
    case 'insertOrUpdate':
        if(empty($_POST['id'])){
            $gradesModel->insertGrade($_POST['name']);
        } else {
            $gradesModel->updateGrade($_POST['id'], $_POST['name']);
        }
        break;
    /*
     * Es para listar/obtener los grados académicos que existen registrados en el sistema con una condición que este activo.
     * Ademas, de dibujar una tabla para mostrar los registros.
     */
    case 'listGrade':
        $grades = $gradesModel->getGrades();

        echo "<h2>Grados Académicos:</h2>";
        foreach ($grades as $grade) {
            echo "ID: " . $grade['id'] . ", Nombre: " . $grade['nombre'] . "<br>";
        }
        break;
    /*
     * Actualizar registros de grados académicos.
     */
    case 'updateGrade':
        if(isset($_POST['id'])){
            $gradesModel->updateGrade($_POST['id'], $_POST['name']);
        }
        break;
    /*
     * Eliminar totalmente registros de grados académicos existentes (eliminado lógico).
     */
    case 'deleteGradeById':
        if(isset($_POST['id'])){
            $gradesModel->deleteGradeById($_POST['id']);
        }
        break;
}
?>
