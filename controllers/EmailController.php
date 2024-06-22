<?php

require_once("../config/database.php");
require_once("../models/Emails.php");
require_once("../models/Users.php");
require_once("../models/Roles.php");

class EmailController
{
    private $emailModel;
    private $userModel;
    private $roleModel;

    public function __construct()
    {
        $this->emailModel = new Emails();
        $this->userModel  = new Users();
        $this->roleModel  = new Roles();
    }

    public function handleRequest()
    {
        switch($_GET['op'])
        {
            case "confirmedEmail":
                if(empty($_POST['id'])){
                    $this->confirmed($_POST['email']);
                }else{
                    $this->confirmedById($_POST['id']);
                }
                break;
            case "changeRole":
                $this->changeRole($_POST['user_id'], $_POST['role_name']);
                break;
        }
    }

    private function confirmed($email)
    {
        $user = $this->userModel->getUserByEmail($email);

        if (empty($user)) {
            $answer = [
                'status' => false,
                'msg'    => 'El usuario no se encuentra registrado. Por favor regístrese en la plataforma.'
            ];
        } elseif ($user['validate'] == 1) {
            $answer = [
                'status' => false,
                'msg'    => 'El usuario ya esta validado. Por favor inicie sesion.'
            ];
        } else {
            $status = $this->sendConfirmationEmail($user);
            if ($status) {
                $answer = [
                    'status' => true
                ];
            } else {
                $answer = [
                    'status' => false,
                    'msg'    => 'Error al enviar el correo electrónico.'
                ];
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }

    private function confirmedById($user_id)
    {
        $user = $this->userModel->getUserById($user_id);

        if (empty($user)) {
            $answer = [
                'status' => false,
                'msg'    => 'El usuario no se encuentra registrado.'
            ];
        } elseif ($user['validate'] == 1) {
            $answer = [
                'status' => false,
                'msg'    => 'El usuario ya está validado. Por favor inicie sesión.'
            ];
        } else {   
            $status = $this->sendConfirmationEmail($user);
            if ($status) {
                $answer = [
                    'status' => true
                ];
            } else {
                $answer = [
                    'status' => false,
                    'msg'    => 'Error al enviar el correo electrónico.'
                ];
            }
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }

    private function sendConfirmationEmail($user)
    {
        $tbody = '';

        $tbody .=
            '
            <td align="left" style="Margin:0;padding-top:20px;padding-right:40px;padding-bottom:20px;padding-left:40px">
                <table width="100%" cellspacing="0" cellpadding="0" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                    <tr style="border-collapse:collapse">
                    <td valign="top" align="center" style="padding:0;Margin:0;width:520px">
                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                        <tr style="border-collapse:collapse">
                        <td align="left" style="padding:0;Margin:0"><h1 style="Margin:0;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;mso-line-height-rule:exactly;letter-spacing:0;font-size:30px;font-style:normal;font-weight:normal;line-height:36px;color:#4A7EB0">Confirmación de Correo Electrónico '.$user['id'].'</h1></td>
                        </tr>
                        <tr style="border-collapse:collapse">
                        <td align="left" style="padding:0;Margin:0;padding-bottom:20px;padding-top:5px;font-size:0">
                        <table width="95%" height="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                            <tr style="border-collapse:collapse">
                            <td style="padding:0;Margin:0;border-bottom:2px solid #999999;background:#FFFFFF none repeat scroll 0% 0%;height:1px;width:100%;margin:0px"></td>
                            </tr>
                        </table></td>
                        </tr>
                        <tr style="border-collapse:collapse">
                        <td align="left" style="padding:0;Margin:0;padding-bottom:10px"><p style="Margin:0;mso-line-height-rule:exactly;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;line-height:24px;letter-spacing:0;color:#666666;font-size:14px"><span style="font-size:16px;line-height:24px">Hola, '.$user['name'].' '.$user['lastname'].',</span></p></td>
                        </tr>
                        <tr style="border-collapse:collapse">
                        <td align="left" style="padding:0;Margin:0"><p style="Margin:0;mso-line-height-rule:exactly;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;line-height:21px;letter-spacing:0;color:#666666;font-size:14px">Por favor verifica tu cuenta, debes oprimir el boton de confirmación. Tu correo electronico '.$user['email'].' sera usado para confirmar unicamente tu cuenta para recibir notificaciones de la plataforma o recuperación de tu clave de seguridad por perdida.</p></td>
                        </tr>
                        <tr style="border-collapse:collapse">
                        <td align="center" style="padding:0;Margin:0;padding-top:20px;padding-bottom:20px"><span class="es-button-border" style="border-style:solid;border-color:#4A7EB0;background:#2CB543;border-width:0px;display:inline-block;border-radius:0px;width:auto"><button type="button" style="mso-style-priority:100 !important; text-decoration:none !important; mso-line-height-rule:exactly; font-family:arial, "helvetica neue", helvetica, sans-serif; font-size:18px; color:#4A7EB0; padding:10px 25px; display:inline-block; background:#EFEFEF; border-radius:0px; font-weight:normal; font-style:normal; line-height:22px; width:auto; text-align:center; letter-spacing:0; mso-padding-alt:0; mso-border-alt:10px solid #EFEFEF"><a href="https://localhost/plataforma-web-colpaz/views/site/confirmed-email?token='.$user['email_confirmed_token'].'" target="_blank" style="color: inherit; text-decoration: none;">Verificar cuenta</a></button></span></td>
                        </tr>
                        <tr style="border-collapse:collapse">
                        <td align="left" style="padding:0;Margin:0"><p style="Margin:0;mso-line-height-rule:exactly;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;line-height:21px;letter-spacing:0;color:#666666;font-size:14px">Si necesitas ayuda, visita la página <a target="_blank" href="https://viewstripo.email/" style="mso-line-height-rule:exactly;text-decoration:underline;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;font-size:14px;color:#4A7EB0">Ayuda</a> o <a target="_blank" href="https://viewstripo.email/" style="mso-line-height-rule:exactly;text-decoration:underline;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;font-size:14px;color:#4A7EB0">contactanos</a>.</p></td>
                        </tr>
                    </table></td>
                    </tr>
                </table></td>
        ';

        return $this->emailModel->confirmedEmail($user, $tbody);
    }

    private function changeRole($user_id, $role_name)
    {
        $tbody  = '';

        $user  = $this->userModel->getUserById($user_id);
        $role  = $this->roleModel->getRolesById($user['role_id'], $user['idr']);

        $tbody .=
        '
            <tr style="border-collapse:collapse">
              <td style="padding:0;Margin:0">
                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;line-height:21px;color:#333333;font-size:14px">Estimado '.$user['name'].' '.$user['lastname'].'</p>
                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;line-height:21px;color:#333333;font-size:14px">Te informamos que tu rol ha sido cambiado por el administrador de la plataforma. A continuación, se detallan los cambios:</p>
                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;line-height:21px;color:#333333;font-size:14px"><b>Rol anterior: </b>'.$role_name.'</p>
                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;line-height:21px;color:#333333;font-size:14px"><b>Nuevo rol: </b>'.$role['name'].'</p>
                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;line-height:21px;color:#333333;font-size:14px"><b>Cambio realizado por: </b>'.$_SESSION['name'].'</p>
                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;line-height:21px;color:#333333;font-size:14px">Si tienes preguntas o inquietudes, no dudes en ponerte en contacto con nosotros.</p></td>
            </tr>
        ';

        $status = $this->emailModel->changeRole($user, $tbody);

        if(!$status){
            $answer = [
                'status' => false,
                'msg' => "No se envio el correo electronico por fallos de conexion"
            ];
        }else{
            $answer = [
                'status' => true
            ];
        }
        echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    }
}

$controller = new EmailController();
$controller->handleRequest();