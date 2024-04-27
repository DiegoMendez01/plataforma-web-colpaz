<?php 

require_once("../config/database.php");
require_once("../models/Users.php");
require_once("../models/Auths.php");
require_once("../models/Roles.php");
require_once("../models/Campuses.php");

$user = new Users();
$role = new Roles();
$campuse = new Campuses();

switch($_GET['op']){
    /*
     * Insertar o actualizar el registro de un usuario. Dependiendo si existe o no el usuario
     * se tomara un flujo
     */
    case 'insertOrUpdate':
        $user->insertOrUpdateUser(((!empty($_POST['id'])) ? $_POST['id'] : null), $_POST['name'], $_POST['lastname'], $_POST['username'], $_POST['identification_type_id'], $_POST['identification'], ((!empty($_POST['password_hash'])) ? $_POST['password_hash'] : null), $_POST['email'], $_POST['phone'], $_POST['phone2'], $_POST['birthdate'], $_POST['sex']);
        break;
    /*
     * Es para listar/obtener los usuarios que existen registrados en el sistema con una condicion que este activo.
     * Ademas, de dibujar una tabla para mostrar los registros
     */
    case 'listUser':
        $datos = $user->getUsersExcludingAdmin($_POST['id'], $_SESSION['idr']);
        
        $data  = [];
        foreach($datos as $row){
            
            $campuseData = $campuse->getCampuseById($row['idr']);
            
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
            $sub_array[] =  '<a onClick="editCampuse('.$row['id'].')"; id="'.$row['id'].'"><span class="label label-pill label-primary">'.$campuseData['name'].'</span></a>';
            
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
        echo json_encode($datos);
    break;
    /*
     * El caso que sirve para actualizar el rol del usuario
     */
    case "updateAsignRole":
        $user->updateAsignRole($_POST['user_id'], $_POST['role_id']);
        break;
    /*
     * El caso que sirve para actualizar el rol del usuario
     */
    case "updateAsignCampuse":
        $user->updateAsignCampuse($_POST['userx_id'], $_POST['idr']);
        break;
    /*
     * Actualizar el registro de un usuario utilizando su perfil de usuario
     */
    case 'updateUserPerfilById':
        if(empty($_POST['identification']) AND empty($_POST['identification_type_id']) AND empty($_POST['sex']) AND empty($_POST['birthdate'])){
            $user->updatePerfilById($_POST['id'], $_POST['name'], $_POST['lastname'], $_POST['password_hash'], $_POST['email'], $_POST['phone'], $_POST['phone2']);
        }else{
            $user->updatePerfilById($_POST['id'], $_POST['name'], $_POST['lastname'], $_POST['password_hash'], $_POST['email'], $_POST['phone'], $_POST['phone2'], $_POST['identification'], $_POST['identification_type_id'], $_POST['sex'], $_POST['birthdate']);
        }
        $_SESSION['name']           = $_POST['name'];
        $_SESSION['lastname']       = $_POST['lastname'];
        $_SESSION['is_google']      = 0;
        $_SESSION['email']          = $_POST['email'];
        $_SESSION['phone']          = $_POST['phone'];
        $_SESSION['password_hash']  = $_POST['password_hash'];
        break;
    /*
     * Listar para comboBox
     */
    case 'comboTeacher':
        $datos = $user->getUsersTeacher();
        if(is_array($datos) == true AND count($datos) > 0){
            $html = "";
            $html.= "<option selected></option>";
            foreach($datos as $row){
                $html.= "<option value='".$row['id']."'>".$row['name']." ".$row['lastname']."</option>";
            }
            echo $html;
        }
        break;
     /*
      * Registrar usuario por Google
      */
    case 'registerGoogle':
        if($_SERVER['REQUEST_METHOD'] === 'POST' AND $_SERVER['CONTENT_TYPE'] === "application/json"){
            // Recuperar JSON del cuerpo POST
            $json    = file_get_contents('php://input');
            $jsonObj = json_decode($json);
            
            if(!empty($jsonObj->request_type) AND $jsonObj->request_type == 'user_auth'){
                $credential = !empty($jsonObj->credential) ? $jsonObj->credential : '';
                
                $parts = explode(".", $credential);
                $header = base64_decode($parts[0]);
                $payload = base64_decode($parts[1]);
                $signature = base64_decode($parts[2]);
                
                $responsePayload = json_decode($payload);
                
                if(!empty($responsePayload)){
                    // Informacion del perdil del usuario
                    $name = !empty($responsePayload->name) ? $responsePayload->name : '';
                    $email = !empty($responsePayload->email) ? $responsePayload->email : '';
                    $picture = !empty($responsePayload->picture) ? $responsePayload->picture : '';
                    $validate = !empty($responsePayload->email_verified) ? 1 : 0;
                }
                
                $dataUser = $user->getUserByEmail($email);
                
                if(empty($dataUser)){
                    $data = $user->insertUserGoogle($name, $email, $picture, $validate);
                    
                    if($data){
                        
                        $user = $user->getUserByEmail($email);
                        $campuseData = $campuse->getCampuseById($user['idr']);
                        $roleData = $role->getRolesById($user['role_id'], $user['idr']);
                        
                        $_SESSION['id']             = $user['id'];
                        $_SESSION['name']           = $user['name'];
                        $_SESSION['lastname']       = $user['lastname'];
                        $_SESSION['email']          = $user['email'];
                        $_SESSION['identification'] = $user['identification'];
                        $_SESSION['password_hash']  = $user['password_hash'];
                        $_SESSION['is_active']      = $user['is_active'];
                        $_SESSION['created']        = $user['created'];
                        $_SESSION['role_id']        = $user['role_id'];
                        $_SESSION['is_google']      = $user['is_update_google'];
                        $_SESSION['role_name']      = $roleData['name'];
                        $_SESSION['campuse']        = $campuseData['name'];
                        $_SESSION['idr']            = $user['idr'];
                        
                        echo json_encode(
                            [
                                'status' => true,
                                'access' => $user['is_update_google']
                            ]
                        );
                    }else{
                        echo json_encode(
                            [
                                'status' => false,
                                'access' => 'Los datos de la cuenta de Google no estan disponibles'
                            ]
                       );
                    }
                }else{
                    $user        = $user->getUserByEmail($email);
                    $roleData    = $role->getRolesById($user['role_id'], $user['idr']);
                    $campuseData = $campuse->getCampuseById($user['idr']);
                    
                    $_SESSION['id']             = $user['id'];
                    $_SESSION['name']           = $user['name'];
                    $_SESSION['lastname']       = $user['lastname'];
                    $_SESSION['email']          = $user['email'];
                    $_SESSION['identification'] = $user['identification'];
                    $_SESSION['password_hash']  = $user['password_hash'];
                    $_SESSION['is_active']      = $user['is_active'];
                    $_SESSION['created']        = $user['created'];
                    $_SESSION['role_id']        = $user['role_id'];
                    $_SESSION['is_google']      = $user['is_update_google'];
                    $_SESSION['role_name']      = $roleData['name'];
                    $_SESSION['campuse']        = $campuseData['name'];
                    $_SESSION['idr']            = $user['idr'];
                    
                    echo json_encode(
                        [
                            'status' => true,
                            'access' => $user['is_update_google']
                        ]
                    );
                }
            }else{
                echo json_encode(
                    [
                        'status' => false,
                        'access' => 'Los datos de la cuenta de Google no estan disponibles'
                    ]
                );
            }
        }
        break;
}
?>