<?php
// Importa la clase del modelo
require_once("../config/database.php");
require_once("../models/Periods.php");

$period = new Periods();

switch($_GET['op'])
{
    /*
     * Insertar o actualizar el registro de un periodo academico. Dependiendo si existe o no el periodo,
     * se tomara un flujo.
     */
    case 'insertOrUpdate':
        $period->insertOrUpdatePeriod($_POST['id'], $_POST['name']);
        break;
    /*
     * Es para listar/obtener los periodos academicos que existen registrados en el sistema con una condicion que este activo.
     * Ademas, de dibujar una tabla para mostrar los registros.
     */
    case 'listPeriod':
        $datos = $period->getPeriods();
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
     * Eliminar totalmente registros de periodos academicos existentes por su ID (eliminado logico).
     */
    case 'deletePeriodById':
        if(isset($_POST['id'])){
            $period->deletePeriodById($_POST['id']);
        }
        break;
    /*
     * Es para listar/obtener los periodos que existen registrados en el sistema.
     * Pero debe mostrar el periodo por medio de su identificador unico
     */
    case 'listPeriodById':
        $data = $period->getPeriodsById($_POST['id']);

        
        $output["id"]                       = $data['id'];
        $output["name"]                     = $data['name'];
        
        echo json_encode($output);
        break;
    /*
     * Listar para comboBox
     */
    case 'combo':
        $datos = $period->getPeriods();
        if(is_array($datos) == true AND count($datos) > 0){
            $html = "";
            $html.= "<option selected></option>";
            foreach($datos as $row){
                $html.= "<option value='".$row['id']."'>".$row['name']."</option>";
            }
            echo $html;
        }
        break;
}
?>
