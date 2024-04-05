<?php

class Users extends Connect
{
    /*
     * Funcion para guardar los datos del usuario en variables de SESSION que servira
     * para mantener esa data mientras el usuario se encuentra logeado y nos ayude a realizar
     * funciones correspondientes a lo largo de su uso. Por medio de los metodos $_POST recibimos
     * la data que viene del formulario de login para guardarlos en variables y validar la consulta
     * para luego guardarlas en las variables de session.
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
                header("Location:".Connect::route()."views/site/index?msg=2");
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
                            $_SESSION['id']             = $result['id'];
                            $_SESSION['name']           = $result['name'];
                            $_SESSION['lastname']       = $result['lastname'];
                            $_SESSION['email']          = $result['email'];
                            $_SESSION['identification'] = $result['identification'];
                            $_SESSION['password_hash']  = $result['password_hash'];
                            $_SESSION['is_active']      = $result['is_active'];
                            $_SESSION['created']        = $result['created'];
                            $_SESSION['role_id']        = $result['role_id'];
                            $_SESSION['role_name']      = $result['role_name'];
                            $_SESSION['is_google']      = $result['is_update_google'];
                            $_SESSION['campuse']        = $result['campuse'];
                            $_SESSION['idr']            = $result['idr'];
                            header("Location:".Connect::route()."views/home/");
                            exit;
                        }else{
                            header("Location:".Connect::route()."views/site/index?msg=3");
                            exit;
                        }
                    }else{
                        header("Location:".Connect::route()."views/site/index?msg=4");
                        exit;
                    }
                }else{
                    header("Location:".Connect::route()."views/site/index?msg=1");
                    exit;
                }
            }
        }
    }
    /*
     * Funcion para insertar/registrar usuarios por medio de un formulario
     */
    public function insertOrUpdateUser($id = null, $name, $lastname, $username, $identification_type_id, $identification, $password_hash = null, $email, $phone, $phone2 = null, $birthdate, $sex)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        if(!empty($id)){
            $condition = 'AND id <> ?';
        }else{
            $condition  = '';
        }
        
        $validateData = "
            SELECT
                identification, username, email, phone
            FROM
                users
            WHERE
                (identification = ? OR username = ? OR email = ? OR phone = ?)".$condition."
        ";
        
        $stmtDuplicate = $conectar->prepare($validateData);
        $stmtDuplicate->bindValue(1, $identification);
        $stmtDuplicate->bindValue(2, $username);
        $stmtDuplicate->bindValue(3, $email);
        $stmtDuplicate->bindValue(4, $phone);
        if(!empty($id)){
            $stmtDuplicate->bindValue(5, $id);
        }
        $stmtDuplicate->execute();
        
        $duplicatedUser = $stmtDuplicate->fetch(PDO::FETCH_ASSOC);
        
        if(is_array($duplicatedUser) && count($duplicatedUser) > 0) {
            $duplicates    = [];
            $duplicateInfo = [];
            
            if ($duplicatedUser['identification'] == $identification) {
                $duplicateInfo[] = ['type' => 'Identificación', 'value' => $duplicatedUser['identification']];
            }
            if ($duplicatedUser['username'] == $username) {
                $duplicateInfo[] = ['type' => 'Nombre de usuario', 'value' => $duplicatedUser['username']];
            }
            if ($duplicatedUser['email'] == $email) {
                $duplicateInfo[] = ['type' => 'Correo', 'value' => $duplicatedUser['email']];
            }
            if ($duplicatedUser['phone'] == $phone) {
                $duplicateInfo[] = ['type' => 'Telefono', 'value' => $duplicatedUser['phone']];
            }
            
            if (!empty($duplicateInfo)) {
                $duplicates = array_merge($duplicates, $duplicateInfo);
            }
            
            $answer = [
                'status' => false,
                'msg'    => $duplicates
            ];
        }else{
            if(empty($id)){
                $resetPassword  = str_replace("$", "a", crypt($email.$lastname.$phone, '$2a$07$afartwetsdAD52356FEDGsfhsd$'));
                $emailToken     = str_replace("$", "a", crypt($email.$username.$name, '$2a$07$afartwetsdAD52356FEDGsfhsd$'));
                $smsCode        = rand(1000, 9999);;
                $password       = password_hash($password_hash, PASSWORD_DEFAULT);
                
                // Concatenar y formatear las credenciales para generar el API key
                $apiKey = sprintf("%s-%s-%s-%s-%s", substr(md5($email), 0, 8), substr(md5($lastname), 0, 4), substr(md5($name), 0, 4), substr(md5(uniqid()), 0, 4), substr(md5(uniqid()), 0, 8));
                
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
                $request = $stmt->execute();
                $action  = 1;
                
                if($request){
                    
                    $idUser = $conectar->lastInsertId();
                    
                    $sql2 = "
                        INSERT INTO
                            auths (user_id, source_id, created, source)
                        VALUES
                            (?, 1, now(), 'WEB')
                    ";
                    
                    $stmt2         = $conectar->prepare($sql2);
                    $stmt2->bindValue(1, $idUser);
                    $requestAuth   = $stmt2->execute();
                }
            }else{
                if(empty($password_hash)){
                    $sqlU = "
                        UPDATE
                            users
                        SET
                            name                    = ?,
                            lastname                = ?,
                            username                = ?,
                            identification_type_id  = ?,
                            identification          = ?,
                            email                   = ?,
                            phone                   = ?,
                            phone2                  = ?,
                            birthdate               = ?,
                            sex                     = ?
                        WHERE
                            id = ? AND is_active = 1
                    ";
                    
                    $stmtUpdate    = $conectar->prepare($sqlU);
                    $stmtUpdate->bindValue(1, $name);
                    $stmtUpdate->bindValue(2, $lastname);
                    $stmtUpdate->bindValue(3, $username);
                    $stmtUpdate->bindValue(4, $identification_type_id);
                    $stmtUpdate->bindValue(5, $identification);
                    $stmtUpdate->bindValue(6, $email);
                    $stmtUpdate->bindValue(7, $phone);
                    $stmtUpdate->bindValue(8, $phone2);
                    $stmtUpdate->bindValue(9, $birthdate);
                    $stmtUpdate->bindValue(10, $sex);
                    $stmtUpdate->bindValue(11, $id);
                    $request = $stmtUpdate->execute();
                    $action  = 2;
                }else{
                    $password       = password_hash($password_hash, PASSWORD_DEFAULT);
                    
                    $sqlU = "
                        UPDATE
                            users
                        SET
                            name                    = ?,
                            lastname                = ?,
                            username                = ?,
                            identification_type_id  = ?,
                            identification          = ?,
                            password_hash           = ?,
                            email                   = ?,
                            phone                   = ?,
                            phone2                  = ?,
                            birthdate               = ?,
                            sex                     = ?
                        WHERE
                            id = ? AND is_active = 1
                    ";
                    
                    $stmtUpdate = $conectar->prepare($sqlU);
                    $stmtUpdate->bindValue(1, $name);
                    $stmtUpdate->bindValue(2, $lastname);
                    $stmtUpdate->bindValue(3, $username);
                    $stmtUpdate->bindValue(4, $identification_type_id);
                    $stmtUpdate->bindValue(5, $identification);
                    $stmtUpdate->bindValue(6, $password);
                    $stmtUpdate->bindValue(7, $email);
                    $stmtUpdate->bindValue(8, $phone);
                    $stmtUpdate->bindValue(9, $phone2);
                    $stmtUpdate->bindValue(10, $birthdate);
                    $stmtUpdate->bindValue(11, $sex);
                    $stmtUpdate->bindValue(12, $id);
                    $request = $stmtUpdate->execute();
                    $action  = 3;
                }
            }
            if($request > 0){
                if($action == 1){
                    if($requestAuth > 0){
                        $answer = [
                            'status' => true,
                            'msg'    => 'El usuario ha sido creado correctamente. Un correo ha sido enviado, si no lo recibe puede reenviarlo oprimiendo el boton "reenviar"',
                            'id'     => $idUser
                        ];
                    }
                }else{
                    $answer = [
                        'status' => true,
                        'msg'    => 'El usuario ha sido actualizado correctamente',
                    ];
                }
            }else{
                $answer = [
                    'status' => false,
                    'msg'    => 'Error al crear el usuario',
                    'error'  => true
                ];
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }
    /*
     * Funcion para actualizar usuario por medio de perfil
     */
    public function updatePerfilById($id, $name, $lastname, $password_hash = null, $email, $phone, $phone2 = null, $identification = null, $identification_type_id = null, $sex = null, $birthdate = null)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $validateData = "
            SELECT
                identification, username, email, phone
            FROM
                users
            WHERE
                (identification = ? OR email = ? OR phone = ?) AND id <> ?
        ";
        
        $stmtDuplicate = $conectar->prepare($validateData);
        $stmtDuplicate->bindValue(1, $identification);
        $stmtDuplicate->bindValue(2, $email);
        $stmtDuplicate->bindValue(3, $phone);
        $stmtDuplicate->bindValue(4, $id);
        $stmtDuplicate->execute();
        
        $duplicatedUser = $stmtDuplicate->fetch(PDO::FETCH_ASSOC);
        
        if(is_array($duplicatedUser) && count($duplicatedUser) > 0) {
            $duplicates    = [];
            $duplicateInfo = [];
            
            if ($duplicatedUser['identification'] == $identification) {
                $duplicateInfo[] = ['type' => 'Identificación', 'value' => $duplicatedUser['identification']];
            }
            if ($duplicatedUser['email'] == $email) {
                $duplicateInfo[] = ['type' => 'Correo', 'value' => $duplicatedUser['email']];
            }
            if ($duplicatedUser['phone'] == $phone) {
                $duplicateInfo[] = ['type' => 'Telefono', 'value' => $duplicatedUser['phone']];
            }
            
            if (!empty($duplicateInfo)) {
                $duplicates = array_merge($duplicates, $duplicateInfo);
            }
            
            echo json_encode(["error" => true, "message" => $duplicates]);
        }else{
            if(!empty($password_hash)){
                $password       = password_hash($password_hash, PASSWORD_DEFAULT);
                $sql = "
                    UPDATE
                        users
                    SET
                        name                    = ?,
                        lastname                = ?,
                        password_hash           = ?,
                        email                   = ?,
                        phone                   = ?,
                        phone2                  = ?";
                if(isset($identification) AND isset($identification_type_id) AND isset($sex) AND isset($birthdate)){
                    $sql .= ",
                        identification          = ?,
                        identification_type_id  = ?,
                        sex = ?,
                        birthdate = ?
                    ";
                }
                $sql .= ",
                        is_update_google        = 0
                    WHERE
                        id = ? AND is_active = 1
                ";
                
                $stmt = $conectar->prepare($sql);
                $stmt->bindValue(1, $name);
                $stmt->bindValue(2, $lastname);
                $stmt->bindValue(3, $password);
                $stmt->bindValue(4, $email);
                $stmt->bindValue(5, $phone);
                $stmt->bindValue(6, $phone2);
                if(isset($identification) AND isset($identification_type_id) AND isset($sex) AND isset($birthdate)){
                    $stmt->bindValue(7, $identification);
                    $stmt->bindValue(8, $identification_type_id);
                    $stmt->bindValue(9, $sex);
                    $stmt->bindValue(10, $birthdate);
                    $stmt->bindValue(11, $id);
                } else {
                    $stmt->bindValue(7, $id);
                }
                $stmt->execute();
            }else{
                
                $sql = "
                    UPDATE
                        users
                    SET
                        name                    = ?,
                        lastname                = ?,
                        email                   = ?,
                        phone                   = ?,
                        phone2                  = ?";
                if(isset($identification) AND isset($identification_type_id) AND isset($sex) AND isset($birthdate)){
                    $sql .= ",
                        identification          = ?,
                        identification_type_id  = ?,
                        sex = ?,
                        birthdate = ?
                    ";
                }
                $sql .= ",
                        is_update_google        = 0
                    WHERE
                        id = ? AND is_active = 1
                ";
                
                $stmt = $conectar->prepare($sql);
                $stmt->bindValue(1, $name);
                $stmt->bindValue(2, $lastname);
                $stmt->bindValue(3, $email);
                $stmt->bindValue(4, $phone);
                $stmt->bindValue(5, $phone2);
                if(isset($identification) AND isset($identification_type_id) AND isset($sex) AND isset($birthdate)){
                    $stmt->bindValue(6, $identification);
                    $stmt->bindValue(7, $identification_type_id);
                    $stmt->bindValue(8, $sex);
                    $stmt->bindValue(9, $birthdate);
                    $stmt->bindValue(10, $id);
                } else {
                    $stmt->bindValue(6, $id);
                }
                $stmt->execute();
            }
            
            return $result = $stmt->fetchAll();
        }
    }
    /*
     * Funcion para traer todos los usuarios registrados hasta el momento menos el de sesion
     */
    public function getUsersExcludingAdmin($id, $idr)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        if($_SESSION['role_id'] == 1){
            $condition = 'AND users.role_id <> 1';
        }else{
            $condition = 'AND users.role_id <> 1 AND users.idr = ?';
        }
        
        $sql = "
            SELECT
                users.*
            FROM
                users
            INNER JOIN roles ON users.role_id = roles.id
            WHERE
                users.is_active = 1 AND users.id <> ?
        ".$condition;
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id);
        if ($_SESSION['role_id'] != 1) {
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
    public function updateAsignRole($id, $role_id)
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
        
        if($role_id == 1 OR $role_id == 2){
            $condition = 'validate = 1';
        }else{
            $condition = '';
        }
        
        $sql = "
            UPDATE
                users
            SET
                role_id = ?,
                $condition
            WHERE
                id = ?
        ";
        
        $sql    = $conectar->prepare($sql);
        $sql->bindValue(1, $role_id);
        $sql->bindValue(2, $id);
        $result = $sql->execute();
        
        if($result){
            $answer = [
                'status'      => true,
                'user_id'     => $id,
                'role_name'   => $old_role['name'],
                'msg'         => 'Registro actualizado correctamente'
            ];
        }else{
            $answer = [
                'status'  => false,
                'msg'     => 'Fallo con la actualizacion del rol',
            ];
        }
        
        // Devolver el rol antiguo y el nuevo
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }
    /*
     *  Funcion para actualizar la sede del usuario
     */
    public function updateAsignCampuse($id, $idr)
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
        $result = $sql->execute();
        
        if($result){
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
        
        // Devolver el rol antiguo y el nuevo
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
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
    public function insertUserGoogle($name, $email, $picture, $validate)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        // Separar el nombre en dos partes (nombre y apellido)
        $name_parts = explode(' ', $name);
        
        $resetPassword  = str_replace("$", "a", crypt($email.$name, '$2a$07$afartwetsdAD52356FEDGsfhsd$'));
        $emailToken     = str_replace("$", "a", crypt($name.$email, '$2a$07$afartwetsdAD52356FEDGsfhsd$'));
        $smsCode        = rand(1000, 9999);;
        $password       = password_hash($name, PASSWORD_DEFAULT);
        
        // Concatenar y formatear las credenciales para generar el API key
        $apiKey = sprintf("%s-%s-%s-%s-%s", substr(md5($email), 0, 8), substr(md5($password), 0, 4), substr(md5($name), 0, 4), substr(md5(uniqid()), 0, 4), substr(md5(uniqid()), 0, 8));
        
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