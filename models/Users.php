<?php

require_once(__DIR__ . "/../docs/Route.php");
require_once(__DIR__ . "/../docs/Session.php");
require_once (__DIR__ . "/../config/database.php");

class Users extends Database
{

    private $session;

    public function __construct()
    {
        $this->session = Session::getInstance();
    }
    /*
     * Funcion para autenticar un usuario al iniciar sesion
     */
    public function login()
    {
        $conectar = parent::connection();
        parent::set_names();
        
        //Validamos si la informacion viene vacia o no, cuando se inicia sesion
        if(isset($_POST["submit"])){
            $identification     = $_POST['identification'];
            $password_hash      = $_POST['password_hash'];
            
            if(empty($identification) AND empty($password_hash)){
                header("Location:".Route::route()."views/site/index?msg=2");
                exit;
            }else{
                $sql = "
                    SELECT
                        u.*,
                        r.name as role_name,
                        r.id as role_id,
                        c.name as campuse
                    FROM
                        users as u
                    INNER JOIN roles r ON u.role_id = r.id
                    INNER JOIN campuses c ON u.idr = c.idr
                    WHERE
                        u.identification = ? AND u.is_active = 1
                ";
                
                $stmt = $conectar->prepare($sql);
                $stmt->bindValue(1, $identification);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if(is_array($result) AND count($result) > 0){
                    if(password_verify($password_hash, $result['password_hash'])){
                        if($result['validate'] == 1){
                            $this->session->put('id', $result['id']);
                            $this->session->put('name', $result['name']);
                            $this->session->put('lastname', $result['lastname']);
                            $this->session->put('email', $result['email']);
                            $this->session->put('identification', $result['identification']);
                            $this->session->put('created', $result['created']);
                            $this->session->put('role_id', $result['role_id']);
                            $this->session->put('role_name', $result['role_name']);
                            $this->session->put('is_google', $result['is_google']);
                            $this->session->put('campuse', $result['campuse']);
                            $this->session->put('idr', $result['idr']);
                            header("Location:".Route::route()."views/home/");
                            exit;
                        }else{
                            header("Location:".Route::route()."views/site/index?msg=3");
                            exit;
                        }
                    }else{
                        header("Location:".Route::route()."views/site/index?msg=4");
                        exit;
                    }
                }else{
                    header("Location:".Route::route()."views/site/index?msg=1");
                    exit;
                }
            }
        }
    }
    
    /*
    * Funcion para duplicidad de informacion del usuario
    */
    public function getUserByIdentificationUsernameOrEmailOrPhone($identification, $email, $phone, $username = null, $id = null) {
        $conectar = parent::connection();
        parent::set_names();
        
        // Condición adicional si se proporciona un ID
        $condition = '';
        if (!empty($id)) {
            $condition = 'AND id <> ?';
        }
    
        // Construir la cláusula WHERE dinámicamente
        $whereConditions = ['identification = ?', 'email = ?', 'phone = ?'];
        $params = [$identification, $email, $phone];
    
        if (!empty($username)) {
            $whereConditions[] = 'username = ?';
            $params[] = $username;
        }
    
        $sql = "
            SELECT
                identification, username, email, phone
            FROM
                users
            WHERE
                (" . implode(' OR ', $whereConditions) . ") $condition
        ";
    
        $stmt = $conectar->prepare($sql);
    
        foreach ($params as $index => $param) {
            $stmt->bindValue($index + 1, $param);
        }
        if (!empty($id)) {
            $stmt->bindValue(count($params) + 1, $id);
        }
    
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /*
     * Funcion para insertar usuarios por medio de un formulario
     */
    public function insertUser($name, $lastname, $username, $identification_type_id, $identification, $password, $email, $phone, $phone2, $birthdate, $sex, $apiKey, $resetPassword, $emailToken, $smsCode) {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            INSERT INTO
                users (name, lastname, username, identification_type_id, identification, password_hash, email, phone, phone2, birthdate, sex, created, role_id, api_key, password_reset_token, email_confirmed_token, sms_code, profile_image, idr)
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now(), 5, ?, ?, ?, ?, 'nodisponible.jpg', 1)
        ";

        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $lastname);
        $stmt->bindValue(3, $username);
        $stmt->bindValue(4, $identification_type_id);
        $stmt->bindValue(5, $identification);
        $stmt->bindValue(6, $password);
        $stmt->bindValue(7, $email);
        $stmt->bindValue(8, $phone);
        $stmt->bindValue(9, $phone2);
        $stmt->bindValue(10, $birthdate);
        $stmt->bindValue(11, $sex);
        $stmt->bindValue(12, $apiKey);
        $stmt->bindValue(13, $resetPassword);
        $stmt->bindValue(14, $emailToken);
        $stmt->bindValue(15, $smsCode);

        if ($stmt->execute()) {

            $idUser = $conectar->lastInsertId();

            $sql2 = "
                INSERT INTO
                    auths (user_id, source_id, created, source)
                VALUES
                    (?, 1, now(), 'WEB')
            ";
            
            $conectar = parent::connection();
            $stmt2 = $conectar->prepare($sql2);
            $stmt2->bindValue(1, $idUser);

            return $idUser;
        }
    }
    /*
     * Funcion para actualizar usuarios por medio de un formulario
     */
    public function updateUser($id, $name, $lastname, $username, $identification_type_id, $identification, $password, $email, $phone, $phone2, $birthdate, $sex) {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            UPDATE
                users
            SET
                name = ?,
                lastname = ?,
                username = ?,
                identification_type_id = ?,
                identification = ?,
                password_hash = ?,
                email = ?,
                phone = ?,
                phone2 = ?,
                birthdate = ?,
                sex = ?
            WHERE
                id = ? AND is_active = 1
        ";

        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $lastname);
        $stmt->bindValue(3, $username);
        $stmt->bindValue(4, $identification_type_id);
        $stmt->bindValue(5, $identification);
        $stmt->bindValue(6, $password);
        $stmt->bindValue(7, $email);
        $stmt->bindValue(8, $phone);
        $stmt->bindValue(9, $phone2);
        $stmt->bindValue(10, $birthdate);
        $stmt->bindValue(11, $sex);
        $stmt->bindValue(12, $id);

        return $stmt->execute();
    }

    public function updateUserWithoutPassword($id, $name, $lastname, $username, $identification_type_id, $identification, $email, $phone, $phone2, $birthdate, $sex) {
        $conectar = parent::connection();
        parent::set_names();

        $sql = "
            UPDATE
                users
            SET
                name = ?,
                lastname = ?,
                username = ?,
                identification_type_id = ?,
                identification = ?,
                email = ?,
                phone = ?,
                phone2 = ?,
                birthdate = ?,
                sex = ?
            WHERE
                id = ? AND is_active = 1
        ";

        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $lastname);
        $stmt->bindValue(3, $username);
        $stmt->bindValue(4, $identification_type_id);
        $stmt->bindValue(5, $identification);
        $stmt->bindValue(6, $email);
        $stmt->bindValue(7, $phone);
        $stmt->bindValue(8, $phone2);
        $stmt->bindValue(9, $birthdate);
        $stmt->bindValue(10, $sex);
        $stmt->bindValue(11, $id);

        return $stmt->execute();
    }
    /*
     * Funcion para actualizar usuario por medio de perfil
     */
    public function updatePerfilByUser($id, $data)
    {
        $conectar = parent::connection();
        parent::set_names();

        $fields = [
            'name'              => $data['name'],
            'lastname'          => $data['lastname'],
            'email'             => $data['email'],
            'phone'             => $data['phone'],
            'phone2'            => $data['phone2'],
            'is_update_google'  => 0,
        ];

        if (!empty($data['password_hash'])) {
            $fields['password_hash'] = password_hash($data['password_hash'], PASSWORD_DEFAULT);
        }

        if (isset($data['identification'])) {
            $fields['identification'] = $data['identification'];
        }
        if (isset($data['identification_type_id'])) {
            $fields['identification_type_id'] = $data['identification_type_id'];
        }
        if (isset($data['sex'])) {
            $fields['sex'] = $data['sex'];
        }
        if (isset($data['birthdate'])) {
            $fields['birthdate'] = $data['birthdate'];
        }

        $sql = "UPDATE users SET ";
        $params = [];
        $i = 1;
        foreach ($fields as $key => $value) {
            $sql .= "$key = ?";
            if ($i < count($fields)) {
                $sql .= ", ";
            }
            $params[] = $value;
            $i++;
        }
        $sql     .= " WHERE id = ? AND is_active = 1";
        $params[] = $id;

        $stmt = $conectar->prepare($sql);

        for ($i = 0; $i < count($params); $i++) {
            $stmt->bindValue($i + 1, $params[$i]);
        }

        $stmt->execute();
        return $stmt->rowCount();
    }
    /*
     * Funcion para traer todos los usuarios registrados hasta el momento menos el de sesion
     */
    public function getUsersExcludingAdmin($id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        if($_SESSION['role_id'] == 1){
            $condition = '';
        }else{
            $condition = 'AND users.idr = ?';
        }
        
        $sql = "
            SELECT
                users.*
            FROM
                users
            INNER JOIN roles ON users.role_id = roles.id
            WHERE
                users.is_active = 1 AND users.id <> ? AND users.role_id <> 1
        ".$condition;
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        if($_SESSION['role_id'] != 1){
            $stmt->bindValue(2, $idr);
        }
        $stmt->execute();
        
        return $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /*
     * Funcion para traer todos los usuarios registrados hasta el momento
     */
    public function getUsers()
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                users.*
            FROM
                users
            INNER JOIN roles ON users.role_id = roles.id
            WHERE
                users.is_active = 1 AND roles.id <> 1
        ";
        
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
    /*
     * Funcion para traer todos los profesores registrados hasta el momento
     */
    public function getUsersTeacher()
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                users.*
            FROM
                users
            INNER JOIN roles ON users.role_id = roles.id
            WHERE
                users.is_active = 1 AND roles.id <> 1 AND users.role_id = 3
        ";
        
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
    /*
     * Funcion para traer todos los estudiantes registrados hasta el momento
     */
    public function getUsersStudent()
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                users.*
            FROM
                users
            INNER JOIN roles ON users.role_id = roles.id
            WHERE
                users.is_active = 1 AND roles.id <> 1 AND users.role_id = 4
        ";
        
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
    /*
     * Funcion para eliminar totalmente registros de usuarios existentes
     */
    public function deleteUserById($id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                users
            SET
                is_active = 0
            WHERE
                id = ?
        ";
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
    /*
     * Funcion para traer los usuarios mediante el ID del usuario
     */
    public function getUserById($id)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                *
            FROM
                users
            WHERE
                id = ?
        ";
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        
        return $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /*
     * Funcion para traer los usuarios mediante el token del usuario
     */
    public function getUserByToken($token)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                *
            FROM
                users
            WHERE
                email_confirmed_token = ?
        ";
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $token);
        $stmt->execute();
        
        return $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /*
     * Funcion para traer los usuarios mediante el email del usuario
     */
    public function getUserByEmail($email)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                *
            FROM
                users
            WHERE
                email = ?
        ";
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $email);
        $stmt->execute();
        
        return $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /*
     *  Funcion para actualizar el rol del usuario
     */
    public function updateAssignedRole($id, $role_id, $condition)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        // Obtener el rol antiguo
        $sqlOldRole = "
            SELECT
                r.name
            FROM
                users u
            INNER JOIN roles as r ON u.role_id = r.id
            WHERE
                u.id = ?
        ";
        $stmtOldRole = $conectar->prepare($sqlOldRole);
        $stmtOldRole->bindValue(1, $id);
        $stmtOldRole->execute();
        $old_role = $stmtOldRole->fetch(PDO::FETCH_ASSOC);
        
        $sql = "
            UPDATE
                users
            SET
                $condition
                role_id = ?
            WHERE
                id = ?
        ";
        
        $sql    = $conectar->prepare($sql);
        $sql->bindValue(1, $role_id);
        $sql->bindValue(2, $id);
        $sql->execute();
        if($sql->execute()){
            return $old_role;
        }else{
            return false;
        }
    }
    /*
     *  Funcion para actualizar la sede del usuario
     */
    public function updateAssignedCampus($id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                users
            SET
                idr = ?
            WHERE
                id = ?
        ";
        $sql    = $conectar->prepare($sql);
        $sql->bindValue(1, $idr);
        $sql->bindValue(2, $id);
        return $sql->execute();
    }
    /*
     *  Funcion para actualizar el token del usuario
     */
    public function updateTokenUser($id, $tokenEmail)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            UPDATE
                users
            SET
                validate = 1,
                email_confirmed_token = ?
            WHERE
                id = ?
        ";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tokenEmail);
        $sql->bindValue(2, $id);
        $sql->execute();
        
        return $result = $sql->fetchAll();
    }
    /*
     *  Funcion para insertar un usuario por Google
     */
    public function insertUserGoogle($email, $picture, $validate, $name_parts, $resetPassword, $emailToken, $smsCode, $apiKey, $password)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            INSERT INTO
                users (name, lastname, username, identification_type_id, identification, password_hash, email, phone, birthdate, sex, created, role_id, api_key, password_reset_token, email_confirmed_token, sms_code, profile_image, validate, is_update_google, idr)
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, now(), ?, now(), 5, ?, ?, ?, ?, ?, ?, 1, 1)
        ";
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $name_parts[0]);
        $stmt->bindValue(2, $name_parts[1]);
        $stmt->bindValue(3, $name_parts[0].time());
        $stmt->bindValue(4, 1);
        $stmt->bindValue(5, $email);
        $stmt->bindValue(6, $password);
        $stmt->bindValue(7, $email);
        $stmt->bindValue(8, $email);
        $stmt->bindValue(9, 'N/A');
        $stmt->bindValue(10, $apiKey);
        $stmt->bindValue(11, $resetPassword);
        $stmt->bindValue(12, $emailToken);
        $stmt->bindValue(13, $smsCode);
        $stmt->bindValue(14, $picture);
        $stmt->bindValue(15, $validate);
        
        if($stmt->execute()){
            
            $idUser = $conectar->lastInsertId();
            
            $sql2 = "
                INSERT INTO
                    auths (user_id, source_id, created, source)
                VALUES
                    (?, 1, now(), 'GOOGLE')
            ";
            
            $stmt2         = $conectar->prepare($sql2);
            $stmt2->bindValue(1, $idUser);
            $result = $stmt2->execute();
            
            return $result;
        }
    }
}

?>