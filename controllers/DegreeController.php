<?php
// Importa la clase del modelo
require_once("../config/database.php");
require_once("../models/Degrees.php");

$degree = new Degrees();

switch($_GET['op'])
{
    /*
     * Insertar o actualizar el registro de un grado academico. Dependiendo si existe o no el grado,
     * se tomara un flujo.
     */
    case 'insertOrUpdate':
        $degree->updateOrInsertDegree($_POST['id'], $_POST['name']);
        break;
    /*
     * Es para listar/obtener los grados academicos que existen registrados en el sistema con una condicion que este activo.
     * Ademas, de dibujar una tabla para mostrar los registros.
     */
    case 'listDegree':
        $datos = $degree->getDegrees();
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
     * Eliminar totalmente registros de grados academicos existentes por su ID (eliminado logico).
     */
    case 'deleteDegreeById':
        if(isset($_POST['id'])){
            $degree->deleteDegreeById($_POST['id']);
        }
        break;
    /*
     * Es para listar/obtener los grados academicos que existen registrados en el sistema.
     * Pero debe mostrar el grado por medio de su identificador unico
     */
    case 'listDegreeById':
        $datos = $degree->getDegreeById($_POST['id']);

        if(is_array($datos) == true AND count($datos)){
            foreach($datos as $row){
                $output["id"]                       = $row['id'];
                $output["name"]                     = $row['name'];
            }
            echo json_encode($output);
        }
        break;
    /*
     * Listar para comboBox
     */
    case 'combo':
        if(empty($_POST['classroom_id'])){
            $datos = $degree->getDegrees();
            if(is_array($datos) == true AND count($datos) > 0){
                $html = "";
                $html.= "<option value='0' selected>Seleccionar</option>";
                foreach($datos as $row){
                    $html.= "<option value='".$row['id']."'>".$row['name']."</option>";
                }
                echo $html;
            }
        }else{
            $datos = $degree->getDegreesByClassroom($_POST['classroom_id']);
            if(is_array($datos) == true AND count($datos) > 0){
                $html = "";
                $html.= "<option value='0' selected>Seleccionar</option>";
                foreach($datos as $row){
                    $html.= "<option value='".$row['id']."'>".$row['name']."</option>";
                }
                echo $html;
            }
        }
        break;
}
?>
