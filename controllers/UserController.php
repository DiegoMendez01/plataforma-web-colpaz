<?php 

require_once("../models/Users.php");
require_once("../models/Auths.php");
require_once("../models/Roles.php");
require_once("../models/Campuses.php");
require_once("../docs/Session.php");

class UserController
{
    private $userModel;
    private $roleModel;
    private $campuseModel;
    private $session;

    public function __construct()
    {
        $this->userModel    = new Users();
        $this->roleModel    = new Roles();
        $this->campuseModel = new Campuses();
        $this->session      = Session::getInstance();
    }

    public function handleRequest()
    {
        if($this->session->has('idr')){
            $idr = $this->session->get('idr');
        }

        switch($_GET['op'])
        {
            case "createOrUpdate":
                if(empty($_POST['id'])){
                    $this->create($_POST['name'], $_POST['lastname'], $_POST['username'], $_POST['identification_type_id'], $_POST['identification'], $_POST['password_hash'], $_POST['email'], $_POST['phone'], $_POST['phone2'], $_POST['birthdate'], $_POST['sex']);
                }else{
                    $this->update($_POST['id'], $_POST['name'], $_POST['lastname'], $_POST['username'], $_POST['identification_type_id'], $_POST['identification'], $_POST['password_hash'], $_POST['email'], $_POST['phone'], $_POST['phone2'], $_POST['birthdate'], $_POST['sex']);
                }
                break;
            case "index":
                $this->index($_POST['id'], $idr);
                break;
            case "delete":
                $this->delete($_POST['id']);
                break;
            case "show":
                $this->show($_POST['id']);
                break;
            case "updateAsignRole":
                $this->updateAssignedRole($_POST['user_id'], $_POST['role_id']);
                break;
            case "updateAsignCampus":
                $this->updateAssignedCampuse($_POST['xid'], $_POST['idr']);
                break;
            case "perfil":
                if(empty($_POST['identification']) AND empty($_POST['identification_type_id']) AND empty($_POST['sex']) AND empty($_POST['birthdate'])){
                    $this->perfil($_POST['id'], $_POST['name'], $_POST['lastname'], $_POST['password_hash'], $_POST['email'], $_POST['phone'], $_POST['phone2']);
                }else{
                    $this->perfil($_POST['id'], $_POST['name'], $_POST['lastname'], $_POST['password_hash'], $_POST['email'], $_POST['phone'], $_POST['phone2'], $_POST['identification'], $_POST['identification_type_id'], $_POST['sex'], $_POST['birthdate']);
                }
                break;
            case "comboTeacher":
                $this->comboTeacher();
                break;
            case "google":
                $this->google();
                break;
            case "comboStudent":
                $this->comboStudent();
                break;
        }
    }

    private function create($name, $lastname, $username, $identification_type_id, $identification, $password_hash, $email, $phone, $phone2 = null, $birthdate, $sex)
    {
        $duplicatedUser = $this->userModel->getUserByIdentificationUsernameOrEmailOrPhone($identification, $email, $phone, $username, null);

        if ($duplicatedUser) {
            $duplicates = [];
            if ($duplicatedUser['identification'] == $identification) {
                $duplicates[] = ['type' => 'Identificación', 'value' => $duplicatedUser['identification']];
            }
            if ($duplicatedUser['username'] == $username) {
                $duplicates[] = ['type' => 'Nombre de usuario', 'value' => $duplicatedUser['username']];
            }
            if ($duplicatedUser['email'] == $email) {
                $duplicates[] = ['type' => 'Correo', 'value' => $duplicatedUser['email']];
            }
            if ($duplicatedUser['phone'] == $phone) {
                $duplicates[] = ['type' => 'Teléfono', 'value' => $duplicatedUser['phone']];
            }

            echo json_encode([
                'status' => false,
                'msg' => $duplicates
            ], JSON_UNESCAPED_UNICODE);
        } else {
            $resetPassword  = str_replace("$", "a", crypt($email.$lastname.$phone, '$2a$07$afartwetsdAD52356FEDGsfhsd$'));
            $emailToken     = str_replace("$", "a", crypt($email.$username.$name, '$2a$07$afartwetsdAD52356FEDGsfhsd$'));
            $smsCode        = rand(1000, 9999);
            $password       = password_hash($password_hash, PASSWORD_DEFAULT);
            
            // Concatenar y formatear las credenciales para generar el API key
            $apiKey = sprintf("%s-%s-%s-%s-%s", substr(md5($email), 0, 8), substr(md5($lastname), 0, 4), substr(md5($name), 0, 4), substr(md5(uniqid()), 0, 4), substr(md5(uniqid()), 0, 8));
            
            $idUser = $this->userModel->insertUser($name, $lastname, $username, $identification_type_id, $identification, $password, $email, $phone, $phone2, $birthdate, $sex, $apiKey, $resetPassword, $emailToken, $smsCode);

            if ($idUser) {
                echo json_encode([
                    'status' => true,
                    'msg' => 'El usuario ha sido creado correctamente. Un correo ha sido enviado, si no lo recibe puede reenviarlo oprimiendo el botón "reenviar"',
                    'id' => $idUser
                ], JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Error al crear el usuario',
                    'error' => true
                ], JSON_UNESCAPED_UNICODE);
            }
        }
    }

    private function update($id, $name, $lastname, $username, $identification_type_id, $identification, $password_hash = null, $email, $phone, $phone2 = null, $birthdate, $sex)
    {
        $duplicatedUser = $this->userModel->getUserByIdentificationUsernameOrEmailOrPhone($identification, $email, $phone, $username, $id);

        if ($duplicatedUser) {
            $duplicates = [];
            if ($duplicatedUser['identification'] == $identification) {
                $duplicates[] = ['type' => 'Identificación', 'value' => $duplicatedUser['identification']];
            }
            if ($duplicatedUser['username'] == $username) {
                $duplicates[] = ['type' => 'Nombre de usuario', 'value' => $duplicatedUser['username']];
            }
            if ($duplicatedUser['email'] == $email) {
                $duplicates[] = ['type' => 'Correo', 'value' => $duplicatedUser['email']];
            }
            if ($duplicatedUser['phone'] == $phone) {
                $duplicates[] = ['type' => 'Teléfono', 'value' => $duplicatedUser['phone']];
            }

            echo json_encode([
                'status' => false,
                'msg' => $duplicates
            ], JSON_UNESCAPED_UNICODE);
        } else {
            if (empty($password_hash)) {
                $request = $this->userModel->updateUserWithoutPassword($id, $name, $lastname, $username, $identification_type_id, $identification, $email, $phone, $phone2, $birthdate, $sex);
            } else {
                $password = password_hash($password_hash, PASSWORD_DEFAULT);
                $request = $this->userModel->updateUser($id, $name, $lastname, $username, $identification_type_id, $identification, $password, $email, $phone, $phone2, $birthdate, $sex);
            }

            if ($request) {
                echo json_encode([
                    'status' => true,
                    'msg' => 'El usuario ha sido actualizado correctamente',
                ], JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode([
                    'status' => false,
                    'msg' => 'Error al actualizar el usuario',
                    'error' => true
                ], JSON_UNESCAPED_UNICODE);
            }
        }
    }

    private function index($id, $idr)
    {
        $users = $this->userModel->getUsersExcludingAdmin($id, $idr);
        $data  = [];

        foreach($users as $user){
            
            $campuseData = $this->campuseModel->getCampuseById($user['idr']);
            
            $sub_array   = [];
            $sub_array[] = $user['name'];
            $sub_array[] = $user['lastname'];
            $sub_array[] = $user['email'];
            $sub_array[] = $user['identification'];
            if($user['role_id'] == 2){
                $sub_array[] = '<a onClick="editarRol('.$user['id'].')"; id="'.$user['id'].'"><span class="label label-pill label-success">Administrador</span></a>';
            }elseif($user['role_id'] == 3){
                $sub_array[] = '<a onClick="editarRol('.$user['id'].')"; id="'.$user['id'].'"><span class="label label-pill label-success">Docente</span></a>';
            }elseif($user['role_id'] == 4){
                $sub_array[] = '<a onClick="editarRol('.$user['id'].')"; id="'.$user['id'].'"><span class="label label-pill label-success">Estudiante</span></a>';
            }elseif($user['role_id'] == 5){
                $sub_array[] = '<a onClick="editarRol('.$user['id'].')"; id="'.$user['id'].'"><span class="label label-pill label-success">Usuario Provisional</span></a>';
            }
            $sub_array[] =  '<a onClick="editCampuse('.$user['id'].')"; id="'.$user['id'].'"><span class="label label-pill label-primary">'.$campuseData['name'].'</span></a>';
            
            $sub_array[] = '<button type="button" onClick="editar('.$user["id"].')"; id="'.$user['id'].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
            $sub_array[] = '<button type="button" onClick="eliminar('.$user["id"].')"; id="'.$user['id'].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
            
            $data[] = $sub_array;
        }
        $results = [
            "sEcho"                 => 1,
            "iTotalRecords"         => count($data),
            "iTotalDisplayRecords"  => count($data),
            "aaData"                => $data
        ];
        echo json_encode($results);
    }

    private function delete($id)
    {
        $this->userModel->deleteUserById($id);
    }

    private function show($id)
    {
        $user = $this->userModel->getUserById($id);
        echo json_encode($user);
    }

    private function updateAssignedRole($id, $role_id)
    {
        if($role_id == 1 OR $role_id == 2){
            $condition = 'validate = 1,';
        }else{
            $condition = '';
        }

        $status = $this->userModel->updateAssignedRole($id, $role_id, $condition);

        if($status){
            $answer = [
                'status'      => true,
                'user_id'     => $id,
                'role_name'   => $status['name'],
                'msg'         => 'Registro actualizado correctamente'
            ];
        }else{
            $answer = [
                'status'  => false,
                'msg'     => 'Fallo con la actualizacion del rol',
            ];
        }

        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }

    private function updateAssignedCampuse($xid, $idr)
    {
        $status = $this->userModel->updateAssignedCampus($xid, $idr);
        if($status){
            $answer = [
                'status'      => true,
                'msg'         => 'Registro actualizado correctamente'
            ];
        }else{
            $answer = [
                'status'  => false,
                'msg'     => 'Fallo con la actualizacion de la sede',
            ];
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }

    private function perfil($id, $name, $lastname, $password_hash = null, $email, $phone, $phone2 = null, $identification = null, $identification_type_id = null, $sex = null, $birthdate = null)
    {
        // Validate for duplicates
        $duplicatedUser = $this->userModel->getUserByIdentificationUsernameOrEmailOrPhone($identification, $email, $phone, null, $id);

        if (is_array($duplicatedUser) && count($duplicatedUser) > 0) {
            $duplicates    = [];
            $duplicateInfo = [];

            if ($duplicatedUser['identification'] == $identification) {
                $duplicateInfo[] = [
                    'type' => 'Identificación',
                    'value' => $duplicatedUser['identification']
                ];
            }
            if ($duplicatedUser['email'] == $email) {
                $duplicateInfo[] = [
                    'type' => 'Correo',
                    'value' => $duplicatedUser['email']
                ];
            }
            if ($duplicatedUser['phone'] == $phone) {
                $duplicateInfo[] = [
                    'type' => 'Teléfono',
                    'value' => $duplicatedUser['phone']
                ];
            }

            if (!empty($duplicateInfo)) {
                $duplicates = array_merge($duplicates, $duplicateInfo);
            }

            echo json_encode(["status" => false, "message" => $duplicates]);
            return;
        }
        // Prepare data for update
        $data = [
            'name'                   => $name,
            'lastname'               => $lastname,
            'email'                  => $email,
            'phone'                  => $phone,
            'phone2'                 => $phone2,
            'password_hash'          => $password_hash,
            'identification'         => $identification,
            'identification_type_id' => $identification_type_id,
            'sex'                    => $sex,
            'birthdate'              => $birthdate,
        ];

        // Update user
        $this->userModel->updatePerfilByUser($id, $data);

        // Update session
        $_SESSION['name']       = $name;
        $_SESSION['lastname']   = $lastname;
        $_SESSION['is_google']  = 0;
        $_SESSION['email']      = $email;
        $_SESSION['phone']      = $phone;
        if ($password_hash !== null) {
            $_SESSION['password_hash'] = $password_hash;
        }
        echo json_encode(["status" => true, "message" => "Perfil actualizado exitosamente"]);
    }

    private function comboTeacher()
    {
        $users = $this->userModel->getUsersTeacher();
        if(is_array($users) == true AND count($users) > 0){
            $html = "";
            $html.= "<option value='0' selected>Seleccionar</option>";
            foreach($users as $user){
                $html.= "<option value='".$user['id']."'>".$user['name']." ".$user['lastname']."</option>";
            }
            echo $html;
        }
    }

    private function comboStudent()
    {
        $users = $this->userModel->getUsersStudent();
        if(is_array($users) == true AND count($users) > 0){
            $html = "";
            $html.= "<option value='0' selected>Seleccionar</option>";
            foreach($users as $user){
                $html.= "<option value='".$user['id']."'>".$user['name']." ".$user['lastname']."</option>";
            }
            echo $html;
        }
    }

    private function google()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST' AND $_SERVER['CONTENT_TYPE'] === "application/json"){
            // Recuperar JSON del cuerpo POST
            $jsonObj = json_decode(file_get_contents('php://input'));
            
            if(!empty($jsonObj->request_type) AND $jsonObj->request_type == 'user_auth'){
                $credential = $jsonObj->credential ?? '';
                [$header, $payload, $signature] = array_map('base64_decode', explode(".", $credential));
                $responsePayload = json_decode($payload);
                
                if (!empty($responsePayload)) {
                    $name       = $responsePayload->name ?? '';
                    $email      = $responsePayload->email ?? '';
                    $picture    = $responsePayload->picture ?? '';
                    $validate   = !empty($responsePayload->email_verified) ? 1 : 0;
                }
                
                $dataUser = $this->userModel->getUserByEmail($email);
                
                if(empty($dataUser)){
                    $name_parts     = explode(' ', $name);
                    $resetPassword  = str_replace("$", "a", crypt($email . $name, '$2a$07$afartwetsdAD52356FEDGsfhsd$'));
                    $emailToken     = str_replace("$", "a", crypt($name . $email, '$2a$07$afartwetsdAD52356FEDGsfhsd$'));
                    $smsCode        = rand(1000, 9999);
                    $password       = password_hash($name, PASSWORD_DEFAULT);
                    $apiKey         = sprintf("%s-%s-%s-%s-%s", substr(md5($email), 0, 8), substr(md5($password), 0, 4), substr(md5($name), 0, 4), substr(md5(uniqid()), 0, 4), substr(md5(uniqid()), 0, 8));
                    
                    $data = $this->userModel->insertUserGoogle($email, $picture, $validate, $name_parts, $resetPassword, $emailToken, $smsCode, $apiKey, $password);
                    
                    if ($data) {
                        $this->setUserSession($email);
                        echo json_encode([
                            'status' => true,
                            'access' => $_SESSION['is_google']
                        ]);
                    } else {
                        echo json_encode([
                            'status' => false,
                            'access' => 'Los datos de la cuenta de Google no están disponibles'
                        ]);
                    }
                } else {
                    $this->setUserSession($email);
                    echo json_encode([
                        'status' => true,
                        'access' => $_SESSION['is_google']
                    ]);
                }
            }else{
                echo json_encode([
                        'status' => false,
                        'access' => 'Los datos de la cuenta de Google no estan disponibles'
                ]);
            }
        }
    }

    private function setUserSession($email) {
        $user        = $this->userModel->getUserByEmail($email);
        $roleData    = $this->roleModel->getRolesById($user['role_id'], $user['idr']);
        $campuseData = $this->campuseModel->getCampuseById($user['idr']);
    
        $_SESSION = [
            'id'             => $user['id'],
            'name'           => $user['name'],
            'lastname'       => $user['lastname'],
            'email'          => $user['email'],
            'identification' => $user['identification'],
            'password_hash'  => $user['password_hash'],
            'is_active'      => $user['is_active'],
            'created'        => $user['created'],
            'role_id'        => $user['role_id'],
            'is_google'      => $user['is_update_google'],
            'role_name'      => $roleData['name'],
            'campuse'        => $campuseData['name'],
            'idr'            => $user['idr']
        ];
    }
}

$controller = new UserController();
$controller->handleRequest();