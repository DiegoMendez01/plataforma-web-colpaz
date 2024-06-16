<?php
// Importa la clase del modelo
require_once("../config/database.php");
require_once("../models/Periods.php");
require_once("../models/Campuses.php");

$period  = new Periods();
$campuse = new Campuses();

$idr     = $_SESSION['idr'];

switch($_GET['op'])
{
    /*
     * Insertar o actualizar el registro de un periodo academico. Dependiendo si existe o no el periodo,
     * se tomara un flujo.
     */
    case 'insertOrUpdate':
        $period->insertOrUpdatePeriod($_POST['id'], $_POST['name'], $idr);
        break;
    /*
     * Es para listar/obtener los periodos academicos que existen registrados en el sistema con una condicion que este activo.
     * Ademas, de dibujar una tabla para mostrar los registros.
     */
    case 'listPeriod':
        $datos = $period->getPeriods($idr);
        $data  = [];
        foreach ($datos as $row) {

            $campuseData    = $campuse->getCampuseById($row['idr']);

            $sub_array      = [];
            $sub_array[]    = $row['name'];
            $sub_array[]    =  '<a onClick="editCampuse('.$row['id'].')"; id="'.$row['id'].'"><span class="label label-pill label-primary">'.$campuseData['name'].'</span></a>';
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
            $period->deletePeriodById($_POST['id'], $idr);
        }
        break;
    /*
     * Es para listar/obtener los periodos que existen registrados en el sistema.
     * Pero debe mostrar el periodo por medio de su identificador unico
     */
    case 'listPeriodById':
        $data = $period->getPeriodsById($_POST['id'], $idr); 
        echo json_encode($data);
        break;
    /*
     * El caso que sirve para actualizar la sede
     */
    case "updateAsignCampuse":
        $period->updateAsignCampuse($_POST['xid'], $_POST['idr']);
        break;
    /*
     * Listar para comboBox
     */
    case 'combo':
        $datos = $period->getPeriods($idr);
        if(is_array($datos) == true AND count($datos) > 0){
            $html = "";
            $html.= "<option value='0' selected>Seleccionar</option>";
            foreach($datos as $row){
                $html.= "<option value='".$row['id']."'>".$row['name']."</option>";
            }
            echo $html;
        }
        break;
}
?>
