<?php

// Libreria para incluir el PHPmailer del composer
require '../includes/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once (__DIR__."/../config/database.php");

Class Emails extends PHPMailer
{
    //Credenciales del correo
    protected $gestorCorreo = 'sapdevertzone@gmail.com';
    protected $gestorPass   = 'oitw nvgh eqyf vpac ';

    // Configuración básica del correo
    public function __construct()
    {
        $this->isSMTP();
        $this->Host         = 'smtp.gmail.com';
        $this->Port         = 587;
        $this->SMTPAuth     = true;
        $this->SMTPSecure   = 'tls';
        $this->Username     = $this->gestorCorreo;
        $this->Password     = $this->gestorPass;
        $this->CharSet      = 'UTF8';
        $this->setFrom($this->gestorCorreo);
        $this->isHTML(true);
    }

    // Método genérico para enviar correos
    protected function sendEmail($user, $subject, $templatePath, $altBody, $tbody)
    {
        $this->Subject = $subject . ' - ' . $user['id'];
        $this->addAddress($user['email']);

        // Armar cuerpo del correo
        $body = file_get_contents($templatePath); /* Ruta del template */
        /* Parametros del template a reemplazar */
        $body = str_replace('$tbldetalle', $tbody, $body);

        $this->Body    = $body;
        $this->AltBody = strip_tags($altBody);

        try {
            $this->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    // Ejemplo de método para enviar correo de confirmación de email
    public function confirmedEmail($user, $tbody)
    {
        return $this->sendEmail($user, 'Confirmar Correo Electronico', '../assets/ConfirmedEmail.html', 'Confirmar Correo Electronico', $tbody);
    }

    // Ejemplo de método para enviar correo de cambio de rol
    public function changeRole($user, $tbody)
    {
        return $this->sendEmail($user, 'Cambio de Rol', '../assets/RoleChange.html', 'Cambio de Rol', $tbody);
    }
}
?>