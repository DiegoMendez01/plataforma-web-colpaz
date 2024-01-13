<?php 

class Auths extends Connect
{
    /*
     * Funcion para insertar/registrar grados académicos por medio de un formulario
     */
    public function insertAuths($username)
    {
        $conectar = parent::connection();

        parent::set_names();
        
        $user = "
            SELECT
                *
            FROM
                users
            WHERE
                username = ? AND is_active = 1
        ";
        
        $stmtUser = $conectar->prepare($user);
        $stmtUser->bindValue(1, $username);
        $stmtUser->execute();
        
        $resultUser = $stmtUser->fetchAll();

        $sql = "
            INSERT INTO
                auths (user_id, source_id, created, source)
            VALUES
                (?, 1, now(), 'WEB')
        ";
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $resultUser[0]['id']);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
}