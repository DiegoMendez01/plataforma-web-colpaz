<?php 

require_once ("../../config/connection.php");

if(!empty($_GET['token'])){
    $token    = $_GET['token'];
    require_once ("../../models/Users.php");
    $user = new Users();
    $dataUser = $user->getUserByToken($token);
    if($dataUser['validate'] === 0){
        if($dataUser['email_confirmed_token'] === $token){
            $emailToken     = str_replace("$", "a", crypt($token.$dataUser['username'].time(), '$2a$07$afartwetsdAD52356FEDGsfhsd$'));
            $user->updateTokenUser($dataUser['id'], $emailToken);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php 
	require_once("../html/mainHead/head.php");
	?>
    <title>Aula Virtual::Confirmación de Correo Electrónico</title>
    <!-- Incluye Bootstrap CSS -->
</head>
<body>
    <div class="page-content" style="margin-top: 0; padding-top: 20px;">
        <div class="container-fluid">
            <header class="section-header">
                <div class="tbl">
                    <div class="tbl-row">
                        <div class="tbl-cell">
                            <ol class="breadcrumb breadcrumb-simple">
                                <li><a href="../site/">Inicio</a></li>
                                <li class="active">Confirmar Correo</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </header>
            <div class="box-typical box-typical-padding text-center">
                    <img class="hidden-md-down" src="../../public/img/LogoCOLPAZ.png" alt="Logo" style="height: 20vh;">
                </div>
            <div class="box-typical box-typical-padding">
                <div class="alert alert-success text-center">
                    <legend>¡Verificación de cuenta exitosa!</legend>
                    <div class="col-md-12">
                        <section class="widget widget-simple-sm-fill green" style="width: 10rem; margin-left: 615px; border-radius: 5rem;">
                            <div class="widget-simple-sm-icon">
                                <span class="badge badge-success">&#10004;</span>
                            </div>
                        </section>
                    </div>
                    <legend>Tu dirección de correo electrónico ha sido confirmada correctamente.</legend>
                    <a href="../site/"><button type="button" class="btn btn-primary">Aceptar</button></a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
        }else{
            header("Location:".Connect::route()."views/site/submitted-email.php?msg=4");
            exit;
        }
    }else{
        header("Location:".Connect::route()."views/site/submitted-email.php?msg=3");
        exit;
    }
}else{
    header("Location:".Connect::route()."views/site/submitted-email.php?msg=2");
    exit;
}
?>
}

