<?php
// Importa la clase del modelo
require_once("../config/connection.php");
require_once("../models/Roles.php");
require_once("../models/Campuses.php");

$roles = new Roles();
$campuse = new Campuses();

$idr   = $_SESSION['idr'];

switch($_GET['op'])
{
    /*
     * Insertar o actualizar el registro de un rol. Dependiendo si existe o no el rol,
     * se tomara un flujo.
     */
    case 'insertOrUpdate':
        $roles->updateOrInsertRole($_POST['id'], $_POST['name'], $_POST['functions'], $idr);
        break;
    /*
     * Es para listar/obtener los roles que existen registrados en el sistema con una condicion que este activo.
     * Ademas, de dibujar una tabla para mostrar los registros.
     */
    case 'listRole':
        $datos = $roles->getRoles($idr);
        $data  = [];
        foreach ($datos as $row) {
            
            $campuseData    = $campuse->getCampuseById($row['idr']);
            
            $sub_array      = [];
            $sub_array[]    = $row['name'];
            $sub_array[]    = $row['functions'];
            $sub_array[]    = $row['created'];
            if($row['is_active'] == 1){
                $sub_array[] = '<span class="label label-success">Activo</span>';
            }
            $sub_array[]    = $campuseData['name'];
            
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
     * Eliminar totalmente registros de roles existentes por su ID (eliminado logico).
     */
    case 'deleteRoleById':
        if(isset($_POST['id'])){
            $roles->deleteRolesById($_POST['id'], $idr);
        }
        break;
    /*
     * Es para listar/obtener los roles que existen registrados en el sistema.
     * Pero debe mostrar el rol por medio de su identificador unico
     */
    case 'listRoleById':
        $datos = $roles->getRolesById($_POST['id'], $idr);
        echo json_encode($datos);
        break;
    /*
     * Listar para comboBox
     */
    case 'combo':
        $datos = $roles->getRoles($idr);
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
