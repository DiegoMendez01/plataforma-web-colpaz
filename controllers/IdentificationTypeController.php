<?php

require_once("../config/connection.php");
require_once("../models/IdentificationTypes.php");

$identificationType = new IdentificationTypes();

switch($_GET['op'])
{
    /*
     * Insertar o actualizar el registro de un tipo de identificacion. Dependiendo si existe o no el aula,
     * se tomara un flujo.
     */
    case 'insertOrUpdate':
        $identificationType->InsertOrupdateIdentificationType($_POST['id'], $_POST['name']);
        break;
    /*
     * Es para listar/obtener los tipos de identificaciones que existen registrados en el sistema con una condicion que este activo.
     * Ademas, de dibujar una tabla para mostrar los registros.
     */
    case 'listIdentificationType':
        $datos = $identificationType->getIdentificationTypes();
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
     * Eliminar totalmente registros de tipo de identificaciones existentes por su ID (eliminado logico).
     */
    case 'deleteIdentificationTypeById':
        if(isset($_POST['id'])){
            $identificationType->deleteIdentificationTypeById($_POST['id']);
        }
        break;
    /*
     * Es para listar/obtener el tipo de identificacion que existe registrados en el sistema.
     * Pero debe mostrar el aula por medio de su identificador unico
     */
    case 'listIdentificationTypeById':
        $data = $identificationType->getIdentificationTypeById($_POST['id']);
        
        $output["id"]           = $data['id'];
        $output["name"]         = $data['name'];
        
        echo json_encode($output);
        break;
    /*
     * Listar para comboBox
     */
    case 'combo':
        $datos = $identificationType->getIdentificationTypes();
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