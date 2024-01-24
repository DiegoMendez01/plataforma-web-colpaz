<?php 

// Librerias necesarias para que el proyecto pueda enviar emails
require('class.phpmailer.php');
require('class.smtp.php');

// Llamada de las clases necesarias que se usaran en el envio del Email
require_once("../config/connection.php");
require_once("../models/Users.php");

Class Emails extends PHPMailer
{
    //Credenciales del correo
    protected $gestorCorreo = 'sapdevertzone@gmail.com';
    protected $gestorPass   = 'oitw nvgh eqyf vpac ';
    
    public function confirmedEmail($id_user)
    {
        $user     = new Users();
        $dataUser = $user->getUserById($id_user);
        
        foreach($dataUser as $row){
            $id                 = $row['id'];
            $name               = $row['name'];
            $lastname           = $row['lastname'];
            $email              = $row['email'];
            $emailConfirmToken  = $row['email_confirmed_token'];
            $apiKey             = $row['api_key'];
        }
        
        // Armar correo a enviar
        $this->isSMTP();
        $this->Host         = 'smtp.gmail.com';
        $this->Port         = 587;
        $this->SMTPAuth     = true;
        $this->Username     = $this->gestorCorreo;
        $this->Password     = $this->gestorPass;
        $this->From         = $this->gestorCorreo;
        $this->SMTPSecure   = 'tls';
        $this->FromName     = $this->tu_nombre = "Confirmar Correo Electronico - ".$id;
        $this->CharSet      = 'UTF8';
        $this->addAddress($email);
        $this->WordWrap     = 50;
        $this->IsHTML(true);
        $this->Subject      = 'Confirmar Correo Electronico';
        
        // Armar cuerpo del correo
        $body           = file_get_contents('../public/ConfirmedEmail.html'); /* Ruta del template */
        /* Parametros del template a reemplazar */
        $body           = str_replace("xnrouser", $id, $body);
        $body           = str_replace("nameUser", $name, $body);
        $body           = str_replace("lastUser", $lastname, $body);
        $body           = str_replace("dataEmail", $email, $body);
        $body           = str_replace("dataToken", $emailConfirmToken, $body);
        
        $this->Body     = $body;
        $this->AltBody  = strip_tags('Confirmar Correo Electronico');
        
        return $this->Send();
    }
}
?>