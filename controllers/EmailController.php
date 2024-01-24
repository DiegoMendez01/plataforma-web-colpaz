<?php

require_once("../config/connection.php");
require_once("../models/Emails.php");

$email = new Emails();

switch($_GET['op'])
{
    // Caso cuando se deba confirmar el correo del usuario registrado
    case 'confirmed_email':
        $email->confirmedEmail($_POST['id']);
        break;
}

?>