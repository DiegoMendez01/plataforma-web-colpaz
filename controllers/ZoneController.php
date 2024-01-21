<?php
// Importa la clase del modelo
require_once("../config/connection.php");
require_once("../models/Zones.php");

$zone = new Zones();

switch($_GET['op'])
{
    /*
     * Insertar o actualizar el registro de una zona.
     */
    case 'insertOrUpdate':
        $zone->insertOrUpdateZone($_POST['id'], $_POST['name']);
        break;
    /*
     * Es para listar/obtener las zonas que existen registrados en el sistema con una condicion que este activo.
     * Ademas, de dibujar una tabla para mostrar los registros.
     */
    case 'listZone':
        $datos = $zone->getZones();
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
     * Eliminar totalmente registros de zonas existentes por su ID (eliminado logico).
     */
    case 'deleteZoneById':
        if(isset($_POST['id'])){
            $zone->deleteZoneById($_POST['id']);
        }
        break;
    /*
     * Es para listar/obtener las zonas que existen registrados en el sistema.
     * Pero debe mostrar la zona por medio de su identificador unico
     */
    case 'listZoneById':
        $datos = $zone->getZoneById($_POST['id']);

        if(is_array($datos) == true AND count($datos)){
            foreach($datos as $row){
                $output["id"]                       = $row['id'];
                $output["name"]                     = $row['name'];
            }
            echo json_encode($output);
        }
        break;
    /*
     * Es para listar/obtener las zonas que existen registrados en el sistema.
     */
    case 'listZones':
        $datos = $zone->getZones();
        echo json_encode($datos);
        break;
}
?>
