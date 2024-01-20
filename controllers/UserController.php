<?php 

require_once("../config/connection.php");
require_once("../models/Users.php");
require_once("../models/Auths.php");

$user = new Users();

switch($_GET['op']){
    /*
     * Insertar o actualizar el registro de un usuario. Dependiendo si existe o no el usuario
     * se tomara un flujo
     */
    case 'insertOrUpdate':
        if(empty($_POST['id'])){
            $user->insertUser($_POST['name'], $_POST['lastname'], $_POST['username'], $_POST['identification_type_id'], $_POST['identification'], $_POST['password_hash'], $_POST['email'], $_POST['phone'], $_POST['phone2'], $_POST['birthdate'], $_POST['sex']);
        }else{
            $user->updateUserById($_POST['id'], $_POST['name'], $_POST['lastname'], $_POST['username'], $_POST['identification_type_id'], $_POST['identification'], $_POST['password_hash'], $_POST['email'], $_POST['phone'], $_POST['phone2'], $_POST['birthdate'], $_POST['sex']);
        }
        break;
    /*
     * Es para listar/obtener los usuarios que existen registrados en el sistema con una condicion que este activo.
     * Ademas, de dibujar una tabla para mostrar los registros
     */
    case 'listUser':
        $datos = $user->getUsers($_POST['id']);
        $data  = [];
        foreach($datos as $row){
            $sub_array   = [];
            $sub_array[] = $row['name'];
            $sub_array[] = $row['lastname'];
            $sub_array[] = $row['email'];
            $sub_array[] = $row['identification'];
            if($row['role_id'] == 2){
                $sub_array[] = '<a onClick="editarRol('.$row['id'].')"; id="'.$row['id'].'"><span class="label label-pill label-success">Administrador</span></a>';
            }elseif($row['role_id'] == 3){
                $sub_array[] = '<a onClick="editarRol('.$row['id'].')"; id="'.$row['id'].'"><span class="label label-pill label-success">Docente</span></a>';
            }elseif($row['role_id'] == 4){
                $sub_array[] = '<a onClick="editarRol('.$row['id'].')"; id="'.$row['id'].'"><span class="label label-pill label-success">Estudiante</span></a>';
            }elseif($row['role_id'] == 5){
                $sub_array[] = '<a onClick="editarRol('.$row['id'].')"; id="'.$row['id'].'"><span class="label label-pill label-success">Usuario Provisional</span></a>';
            }
            
            $sub_array[] = '<button type="button" onClick="editar('.$row["id"].')"; id="'.$row['id'].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
            $sub_array[] = '<button type="button" onClick="eliminar('.$row["id"].')"; id="'.$row['id'].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
            
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
     * Eliminar un usuario por medio de su identificador
     */
    case 'deleteUserById':
        $user->deleteUserById($_POST['id']);
        break;
    /*
     * Es para listar/obtener los usuarios que existen registrados en el sistema.
     * Pero debe mostrar el usuario por medio de su identificador unico
     */
    case 'listUserById':
        $datos = $user->getUserById($_POST['id']);
        
        if(is_array($datos) == true AND count($datos)){
            foreach($datos as $row){
                $output["id"]                       = $row['id'];
                $output["name"]                     = $row['name'];
                $output["lastname"]                 = $row['lastname'];
                $output["username"]                 = $row['username'];
                $output["email"]                    = $row['email'];
                $output["identification_type_id"]   = $row['identification_type_id'];
                $output["identification"]           = $row['identification'];
                $output["password_hash"]            = $row['password_hash'];
                $output["phone"]                    = $row['phone'];
                $output["phone2"]                   = $row['phone2'];
                $output["birthdate"]                = $row['birthdate'];
                $output["sex"]                      = $row['sex'];
            }
            echo json_encode($output);
        }
    break;
    /*
     * El caso que sirve para enviar el ID para el formulario de asignacion de roles
     */
    case "mostrar":
        $datos = $user->getUserById($_POST['id']);
        
        if(is_array($datos) == true AND count($datos) <> 0){
            foreach($datos as $row){
                $output["id"]                       = $row['id'];
            }
            echo json_encode($output);
        }
        break;
    /*
     * El caso que sirve para actualizar el rol del usuario
     */
    case "updateAsignRole":
        $user->updateAsignRole($_POST['user_id'], $_POST['role_id']);
        break;
    /*
     * Actualizar el registro de un usuario utilizando su perfil de usuario
     */
    case 'updateUserPerfilById':
        $user->updatePerfilById($_POST['id'], $_POST['name'], $_POST['lastname'], $_POST['password_hash'], $_POST['email'], $_POST['phone'], $_POST['phone2']);
        $_SESSION['name']           = $_POST['name'];
        $_SESSION['lastname']       = $_POST['lastname'];
        $_SESSION['email']          = $_POST['email'];
        $_SESSION['phone']          = $_POST['phone'];
        $_SESSION['password_hash']  = $_POST['password_hash'];
        break;
    /*
     * Es para listar/obtener los usuarios que existen registrados en el sistema.
     */
    case 'listUsers':
        $datos = $user->getUserAll();
        echo json_encode($datos);
        break;
}
?>