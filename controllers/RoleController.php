<?php
// Importa la clase del modelo
require_once("../config/connection.php");
require_once("../models/Roles.php");

$roles = new Roles();

switch($_GET['op'])
{
    /*
     * Insertar o actualizar el registro de un rol. Dependiendo si existe o no el rol,
     * se tomara un flujo.
     */
    case 'insertOrUpdate':
        $roles->updateOrInsertRole($_POST['id'], $_POST['name'], $_POST['functions']);
        break;
    /*
     * Es para listar/obtener los roles que existen registrados en el sistema con una condicion que este activo.
     * Ademas, de dibujar una tabla para mostrar los registros.
     */
    case 'listRole':
        $datos = $roles->getRoles();
        $data  = [];
        foreach ($datos as $row) {
            $sub_array      = [];
            $sub_array[]    = $row['name'];
            $sub_array[]    = $row['functions'];
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
     * Eliminar totalmente registros de roles existentes por su ID (eliminado logico).
     */
    case 'deleteRoleById':
        if(isset($_POST['id'])){
            $roles->deleteRolesById($_POST['id']);
        }
        break;
    /*
     * Es para listar/obtener los roles que existen registrados en el sistema.
     * Pero debe mostrar el rol por medio de su identificador unico
     */
    case 'listRoleById':
        $datos = $roles->getRolesById($_POST['id']);
        
        if(is_array($datos) == true AND count($datos)){
            foreach($datos as $row){
                $output["id"]           = $row['id'];
                $output["name"]         = $row['name'];
                $output["functions"]    = $row['functions'];
            }
            echo json_encode($output);
        }
        break;
}
?>
