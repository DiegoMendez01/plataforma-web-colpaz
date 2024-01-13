<?php
// Importa la clase del modelo
require_once("../config/connection.php");
require_once("../models/Classrooms.php");

$classroom = new Classrooms();

switch($_GET['op'])
{
    /*
     * Insertar o actualizar el registro de un grado academico. Dependiendo si existe o no el grado,
     * se tomara un flujo.
     */
    case 'insertOrUpdate':
        if(empty($_POST['id'])){
            $classroom->insertClassroom($_POST['name']);
        } else {
            $classroom->updateClassroom($_POST['id'], $_POST['name']);
        }
        break;
    /*
     * Es para listar/obtener los grados academicos que existen registrados en el sistema con una condicion que este activo.
     * Ademas, de dibujar una tabla para mostrar los registros.
     */
    case 'listClassroom':
        $datos = $classroom->getClassrooms();
        
        foreach ($datos as $row) {
            $sub_array      = [];
            $sub_array[]    = $row['name'];
            $sub_array[]    = $row['created'];
            if($row['is_active'] == 1){
                $sub_array[] = 'Activo';
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
     * Eliminar totalmente registros de grados academicos existentes por su ID (eliminado logico).
     */
    case 'deleteClassroomById':
        if(isset($_POST['id'])){
            $classroom->deleteClassroomById($_POST['id']);
        }
        break;
    /*
     * Es para listar/obtener los usuarios que existen registrados en el sistema.
     * Pero debe mostrar el usuario por medio de su identificador unico
     */
    case 'listClassroomById':
        $datos = $classroom->getClassroomById($_POST['id']);
        
        if(is_array($datos) == true AND count($datos)){
            foreach($datos as $row){
                $output["id"]                       = $row['id'];
                $output["name"]                     = $row['name'];
            }
            echo json_encode($output);
        }
        break;
    /*
     * Es para listar/obtener los usuarios que existen registrados en el sistema.
     */
    case 'listClassrooms':
        $datos = $classroom->getClassrooms();
        echo json_encode($datos);
        break;
}
?>
