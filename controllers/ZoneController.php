<?php
// Importa la clase del modelo
require_once("../config/database.php");
require_once("../models/Zones.php");
require_once("../models/Campuses.php");

$zone    = new Zones();
$campuse = new Campuses();

$idr = $_SESSION['idr'];

switch($_GET['op'])
{
    /*
     * Insertar o actualizar el registro de una zona.
     */
    case 'insertOrUpdate':
        $zone->insertOrUpdateZone($_POST['id'], $_POST['name'], $idr);
        break;
    /*
     * Es para listar/obtener las zonas que existen registrados en el sistema con una condicion que este activo.
     * Ademas, de dibujar una tabla para mostrar los registros.
     */
    case 'listZone':
        $datos = $zone->getZones($idr);
        $data  = [];
        foreach ($datos as $row) {

            $campuseData = $campuse->getCampuseById($row['idr']);

            $sub_array      = [];
            $sub_array[]    = $row['name'];
            $sub_array[] =  '<a onClick="editCampuse('.$row['id'].')"; id="'.$row['id'].'"><span class="label label-pill label-primary">'.$campuseData['name'].'</span></a>';
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
     * El caso que sirve para actualizar la sede
     */
    case "updateAsignCampuse":
        $zone->updateAsignCampuse($_POST['xid'], $_POST['idr']);
        break;
    /*
     * Eliminar totalmente registros de zonas existentes por su ID (eliminado logico).
     */
    case 'deleteZoneById':
        if(isset($_POST['id'])){
            $zone->deleteZoneById($_POST['id'], $idr);
        }
        break;
    /*
     * Es para listar/obtener las zonas que existen registrados en el sistema.
     * Pero debe mostrar la zona por medio de su identificador unico
     */
    case 'listZoneById':
        $datos = $zone->getZoneById($_POST['id'], $idr);
        echo json_encode($datos);
        break;
    /*
     * Es para listar/obtener las zonas que existen registrados en el sistema.
     */
    case 'listZones':
        $datos = $zone->getZones($idr);
        echo json_encode($datos);
        break;
}
?>
