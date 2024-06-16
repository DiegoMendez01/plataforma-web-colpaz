<?php

require_once("../config/database.php");
require_once("../models/Emails.php");

$email = new Emails();

switch($_GET['op'])
{
    // Caso cuando se deba confirmar el correo del usuario registrado
    case 'confirmed_email':
        if(empty($_POST['id'])){
            $email->confirmedEmail(null, $_POST['email']);
        }else{
            $email->confirmedEmail($_POST['id'], null);
        }
        break;
    // Caso cuando se cambia el rol del usuario
    case 'change_role':
        $email->changeRole($_POST['user_id'], $_POST['role_name']);
        break;
}

?>