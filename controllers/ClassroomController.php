<?php
// Importa la clase del modelo
require_once("../config/connection.php");
require_once("../models/Classrooms.php");

$classroom = new Classrooms();

switch($_GET['op'])
{
    /*
     * Insertar o actualizar el registro de un aula academica. Dependiendo si existe o no el aula,
     * se tomara un flujo.
     */
    case 'insertOrUpdate':
        $classroom->InsertOrupdateClassroom($_POST['id'], $_POST['name']);
        break;
    /*
     * Es para listar/obtener las aulas academicas que existen registrados en el sistema con una condicion que este activo.
     * Ademas, de dibujar una tabla para mostrar los registros.
     */
    case 'listClassroom':
        $datos = $classroom->getClassrooms();
        $data  = [];
        foreach ($datos as $row) {
            $sub_array      = [];
            $sub_array[]    = $row['name'];
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
     * Eliminar totalmente registros de aulas academicas existentes por su ID (eliminado logico).
     */
    case 'deleteClassroomById':
        if(isset($_POST['id'])){
            $classroom->deleteClassroomById($_POST['id']);
        }
        break;
    /*
     * Es para listar/obtener las aulas que existen registrados en el sistema.
     * Pero debe mostrar el aula por medio de su identificador unico
     */
    case 'listClassroomById':
        $data = $classroom->getClassroomById($_POST['id']);
        
        $output["id"]           = $data['id'];
        $output["name"]         = $data['name'];
        
        echo json_encode($output);
        break;
    /*
     * Es para listar/obtener las aulas que existen registrados en el sistema.
     */
    case 'listClassrooms':
        $datos = $classroom->getClassrooms();
        echo json_encode($datos);
        break;
}
?>
