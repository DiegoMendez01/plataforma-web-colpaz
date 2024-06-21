<?php 

// Libreria para incluir el PHPmailer del composer
require '../includes/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Llamada de las clases necesarias que se usaran en el envio del Email
require_once("../config/database.php");
require_once("../models/Users.php");
require_once("../models/Roles.php");

Class Emails extends PHPMailer
{
    //Credenciales del correo
    protected $gestorCorreo = 'sapdevertzone@gmail.com';
    protected $gestorPass   = 'oitw nvgh eqyf vpac ';

    public function confirmedEmail($user, $tbody)
    {        
        // Armar correo a enviar
        $this->isSMTP();
        $this->Host         = 'smtp.gmail.com';
        $this->Port         = 587;
        $this->SMTPAuth     = true;
        $this->SMTPSecure   = 'tls';
        
        $this->Username     = $this->gestorCorreo;
        $this->Password     = $this->gestorPass;
        $this->setFrom($this->gestorCorreo, "Confirmar Correo Electronico - ".$user['id']);
        
        $this->CharSet      = 'UTF8';
        $this->addAddress($user['email']);
        $this->IsHTML(true);
        $this->Subject      = 'Confirmar Correo Electronico';
        
        // Armar cuerpo del correo
        $body           = file_get_contents('../assets/ConfirmedEmail.html'); /* Ruta del template */
        /* Parametros del template a reemplazar */
        $body = str_replace('$tbldetalle', $tbody, $body);
        
        $this->Body     = $body;
        $this->AltBody  = strip_tags('Confirmar Correo Electronico');
        
        try{
            $this->Send();
            return true;
        }catch(Exception $e){
            return false;
        }
    }

    public function confirmedEmailById($user, $tbody)
    {
        // Armar correo a enviar
        $this->isSMTP();
        $this->Host         = 'smtp.gmail.com';
        $this->Port         = 587;
        $this->SMTPAuth     = true;
        $this->SMTPSecure   = 'tls';
        
        $this->Username     = $this->gestorCorreo;
        $this->Password     = $this->gestorPass;
        $this->setFrom($this->gestorCorreo, "Confirmar Correo Electronico - ".$user['id']);
        
        $this->CharSet      = 'UTF8';
        $this->addAddress($user['email']);
        $this->IsHTML(true);
        $this->Subject      = 'Confirmar Correo Electronico';
        
        // Armar cuerpo del correo
        $body           = file_get_contents('../assets/ConfirmedEmail.html'); /* Ruta del template */
        /* Parametros del template a reemplazar */
        $body = str_replace('$tbldetalle', $tbody, $body);
        
        $this->Body     = $body;
        $this->AltBody  = strip_tags('Confirmar Correo Electronico');
        
        try{
            $this->Send();
            return true;
        }catch(Exception $e){
            return false;
        }
    }
    
    public function changeRole($user, $tbody)
    {   
        // Armar correo a enviar
        $this->isSMTP();
        $this->Host         = 'smtp.gmail.com';
        $this->Port         = 587;
        $this->SMTPAuth     = true;
        $this->SMTPSecure   = 'tls';
        
        $this->Username     = $this->gestorCorreo;
        $this->Password     = $this->gestorPass;
        $this->setFrom($this->gestorCorreo, "Cambio de Rol - ".$user['id']);
        
        $this->CharSet      = 'UTF8';
        $this->addAddress($user['email']);
        $this->IsHTML(true);
        $this->Subject      = 'Cambio de Rol';
        
        // Armar cuerpo del correo
        $body           = file_get_contents('../assets/RoleChange.html'); /* Ruta del template */
        /* Parametros del template a reemplazar */
        $body = str_replace('$tbldetalle', $tbody, $body);
        
        $this->Body     = $body;
        $this->AltBody  = strip_tags('Cambio de Rol');
        
        try{
            $this->Send();
            return true;
        }catch(Exception $e){
            return false;
        }
    }
}
?>