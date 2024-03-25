<?php 

// Libreria para incluir el PHPmailer del composer
require '../includes/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Llamada de las clases necesarias que se usaran en el envio del Email
require_once("../config/connection.php");
require_once("../models/Users.php");
require_once("../models/Roles.php");

Class Emails extends PHPMailer
{
    //Credenciales del correo
    protected $gestorCorreo = 'sapdevertzone@gmail.com';
    protected $gestorPass   = 'oitw nvgh eqyf vpac ';
    
    public function confirmedEmail($id_user = null, $emailSubmmit = null)
    {
        $tbody    = '';
        $user     = new Users();
        $dataUser = ($id_user)? $user->getUserById($id_user) : $user->getUserByEmail($emailSubmmit);
        
        if($emailSubmmit){
            if(empty($dataUser)){
                $answer = [
                    'status' => false,
                    'msg'    => 'El usuario no se encuentra registrado. Por favor registrese en la plataforma.'
                ];
            }
        }
        
        if(empty($answer)){
            foreach($dataUser as $row){
                $id                 = $row['id'];
                $name               = $row['name'];
                $lastname           = $row['lastname'];
                $email              = $row['email'];
                $validate           = $row['validate'];
                $emailConfirmToken  = $row['email_confirmed_token'];
            }
            
            if($validate == 1){
                $answer = [
                    'status' => false,
                    'msg'    => 'El usuario se encuentra validado. Por favor inicie sesión'
                ];
            }
            
            if(empty($answer)){
                $tbody .=
                '
                    <td align="left" style="Margin:0;padding-top:20px;padding-right:40px;padding-bottom:20px;padding-left:40px">
                       <table width="100%" cellspacing="0" cellpadding="0" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                         <tr style="border-collapse:collapse">
                          <td valign="top" align="center" style="padding:0;Margin:0;width:520px">
                           <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                             <tr style="border-collapse:collapse">
                              <td align="left" style="padding:0;Margin:0"><h1 style="Margin:0;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;mso-line-height-rule:exactly;letter-spacing:0;font-size:30px;font-style:normal;font-weight:normal;line-height:36px;color:#4A7EB0">Confirmación de Correo Electrónico '.$id.'</h1></td>
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
                              <td align="left" style="padding:0;Margin:0;padding-bottom:10px"><p style="Margin:0;mso-line-height-rule:exactly;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;line-height:24px;letter-spacing:0;color:#666666;font-size:14px"><span style="font-size:16px;line-height:24px">Hola, '.$name.' '.$lastname.',</span></p></td>
                             </tr>
                             <tr style="border-collapse:collapse">
                              <td align="left" style="padding:0;Margin:0"><p style="Margin:0;mso-line-height-rule:exactly;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;line-height:21px;letter-spacing:0;color:#666666;font-size:14px">Por favor verifica tu cuenta, debes oprimir el boton de confirmación. Tu correo electronico '.$email.' sera usado para confirmar unicamente tu cuenta para recibir notificaciones de la plataforma o recuperación de tu clave de seguridad por perdida.</p></td>
                             </tr>
                             <tr style="border-collapse:collapse">
                               <td align="center" style="padding:0;Margin:0;padding-top:20px;padding-bottom:20px"><span class="es-button-border" style="border-style:solid;border-color:#4A7EB0;background:#2CB543;border-width:0px;display:inline-block;border-radius:0px;width:auto"><button type="button" style="mso-style-priority:100 !important; text-decoration:none !important; mso-line-height-rule:exactly; font-family:arial, "helvetica neue", helvetica, sans-serif; font-size:18px; color:#4A7EB0; padding:10px 25px; display:inline-block; background:#EFEFEF; border-radius:0px; font-weight:normal; font-style:normal; line-height:22px; width:auto; text-align:center; letter-spacing:0; mso-padding-alt:0; mso-border-alt:10px solid #EFEFEF"><a href="https://localhost/plataforma-web-colpaz/views/site/confirmed-email?token='.$emailConfirmToken.'" target="_blank" style="color: inherit; text-decoration: none;">Verificar cuenta</a></button></span></td>
                              </tr>
                             <tr style="border-collapse:collapse">
                              <td align="left" style="padding:0;Margin:0"><p style="Margin:0;mso-line-height-rule:exactly;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;line-height:21px;letter-spacing:0;color:#666666;font-size:14px">Si necesitas ayuda, visita la página <a target="_blank" href="https://viewstripo.email/" style="mso-line-height-rule:exactly;text-decoration:underline;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;font-size:14px;color:#4A7EB0">Ayuda</a> o <a target="_blank" href="https://viewstripo.email/" style="mso-line-height-rule:exactly;text-decoration:underline;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;font-size:14px;color:#4A7EB0">contactanos</a>.</p></td>
                             </tr>
                           </table></td>
                         </tr>
                       </table></td>
                ';
                
                // Armar correo a enviar
                $this->isSMTP();
                $this->Host         = 'smtp.gmail.com';
                $this->Port         = 587;
                $this->SMTPAuth     = true;
                $this->SMTPSecure   = 'tls';
                
                $this->Username     = $this->gestorCorreo;
                $this->Password     = $this->gestorPass;
                $this->setFrom($this->gestorCorreo, "Confirmar Correo Electronico - ".$id);
                
                $this->CharSet      = 'UTF8';
                $this->addAddress($email);
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
                    echo json_encode([
                        'status' => true
                    ]);
                }catch(Exception $e){
                    $answer = [
                        'status' => false,
                        'msg'    => $e
                    ];
                }
            }
        }
        if(!empty($answer)){
            echo json_encode($answer, JSON_UNESCAPED_UNICODE);
        }
    }
    
    public function changeRole($id, $role_name)
    {
        $tbody     = '';
        
        $userModel = new Users();
        $roleModel = new Roles();
        $userData  = $userModel->getUserById($id);
        $roleData  = $roleModel->getRolesById($userData[0]['role_id']);
        
        
        $tbody .=
        '
            <tr style="border-collapse:collapse">
              <td style="padding:0;Margin:0">
                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;line-height:21px;color:#333333;font-size:14px">Estimado '.$userData[0]['name'].' '.$userData[0]['lastname'].'</p>
                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;line-height:21px;color:#333333;font-size:14px">Te informamos que tu rol ha sido cambiado por el administrador de la plataforma. A continuación, se detallan los cambios:</p>
                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;line-height:21px;color:#333333;font-size:14px"><b>Rol anterior: </b>'.$role_name.'</p>
                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;line-height:21px;color:#333333;font-size:14px"><b>Nuevo rol: </b>'.$roleData['name'].'</p>
                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;line-height:21px;color:#333333;font-size:14px"><b>Cambio realizado por: </b>'.$_SESSION['name'].'</p>
                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;line-height:21px;color:#333333;font-size:14px">Si tienes preguntas o inquietudes, no dudes en ponerte en contacto con nosotros.</p></td>
            </tr>
        ';
        
        // Armar correo a enviar
        $this->isSMTP();
        $this->Host         = 'smtp.gmail.com';
        $this->Port         = 587;
        $this->SMTPAuth     = true;
        $this->SMTPSecure   = 'tls';
        
        $this->Username     = $this->gestorCorreo;
        $this->Password     = $this->gestorPass;
        $this->setFrom($this->gestorCorreo, "Cambio de Rol - ".$userData[0]['id']);
        
        $this->CharSet      = 'UTF8';
        $this->addAddress($userData[0]['email']);
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
            echo json_encode([
                'status' => true
            ]);
        }catch(Exception $e){
            echo json_encode([
                'status' => false,
                'msg'    => $e
            ]);
        }
    }
}
?>