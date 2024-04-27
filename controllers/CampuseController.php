<?php
// Importa la clase del modelo
require_once("../config/connection.php");
require_once("../models/Campuses.php");

$campuse = new Campuses();

switch($_GET['op'])
{
    /*
     * Insertar o actualizar el registro de una sede. Dependiendo si existe o no la sede,
     * se tomara un flujo.
     */
    case 'insertOrUpdate':
        $campuse->insertOrUpdateCampuse($_POST['idr'], $_POST['name'], $_POST['description']);
        break;
    /*
     * Es para listar/obtener las sedes que existen registrados en el sistema con una condicion que este activo.
     * Ademas, de dibujar una tabla para mostrar los registros.
     */
    case 'listCampuse':
        $datos = $campuse->getCampuses();
        $data  = [];
        foreach ($datos as $row) {
            $sub_array      = [];
            $sub_array[]    = $row['name'];
            $sub_array[]    = $row['created'];
            if($row['is_active'] == 1){
                $sub_array[] = '<span class="label label-success">Activo</span>';
            }
            
            $sub_array[] = '<button type="button" onClick="editar('.$row["idr"].')"; id="'.$row['idr'].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
            $sub_array[] = '<button type="button" onClick="eliminar('.$row["idr"].')"; id="'.$row['idr'].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
            $sub_array[] = '<button type="button" onClick="ver('.$row["idr"].')"; id="'.$row['idr'].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
            
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
     * Eliminar totalmente registros de sedes existentes por su ID (eliminado logico).
     */
    case 'deleteCampuseByIdr':
        if(isset($_POST['idr'])){
            $campuse->deleteCampuseById($_POST['idr']);
        }
        break;
    /*
     * Es para listar/obtener las sedes que existen registrados en el sistema.
     */
    case 'listCampuseByIdr':
        $data = $campuse->getCampuseById($_POST['idr']);
        
        $output["idr"]          = $data['idr'];
        $output["name"]         = $data['name'];
        $output["description"]  = $data['description'];
        
        echo json_encode($output);
        break;
    /*
     * Listar para comboBox
     */
    case 'combo':
        $datos = $campuse->getCampuses();
        if(is_array($datos) == true AND count($datos) > 0){
            $html = "";
            $html.= "<option selected></option>";
            foreach($datos as $row){
                $html.= "<option value='".$row['idr']."'>".$row['name']."</option>";
            }
            echo $html;
        }
        break;
}
?>
