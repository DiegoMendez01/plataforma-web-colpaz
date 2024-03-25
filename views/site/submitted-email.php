<?php
require_once("../../config/connection.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
    require_once ("../html/mainHead/head.php");
    ?>
    <title>Aula Virtual: Reenviar Correo Electrónico</title>
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
                                <li class="active">Reenvio de Correo</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </header>
            <div class="box-typical box-typical-padding">
                <p>
                    Módulo que permite al usuario el reenvio de un correo electronico para confirmar su cuenta.
                </p>
                <?php 
                if(isset($_GET['msg'])){
                    switch($_GET['msg'])
                    {
                        case "1":
                        ?>
                            <div class="alert alert-success text-center">
                                <legend>Se ha reenviado tu correo electronico. Verifica la bandeja de entrada</legend>
                            </div>
                        <?php
                        break;
                        case "2":
                            ?>
                            <div class="alert alert-danger text-center">
                                <legend>No tienes un token de validacion de cuenta. Por favor vuelve a reenviar el correo electronico.</legend>
                            </div>
                        <?php
                        break;
                        case "3":
                            ?>
                            <div class="alert alert-danger text-center">
                                <legend>El usuario se encuentra validado. Por favor inicia sesión para ingreso de la plataforma.</legend>
                            </div>
                        <?php
                        break;
                        case "4":
                            ?>
                            <div class="alert alert-danger text-center">
                                <legend>El token con el que accedes esta vencido. Realiza un reenvio de correo electronico</legend>
                            </div>
                        <?php
                        break;
                    }
                }
                 ?>
                <div class="col-md-12 text-center">
                    <img class="hidden-md-down" src="../../assets/img/LogoCOLPAZ.png" alt="Logo" style="height: 20vh;">
                </div>
                <h2>Formulario de Reenvío de Correo Electrónico</h2>
                <form method="post" id="submitted_email">
                    <div class="form-group">
                        <label for="email">Correo Electronico <b>*</b></label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Ingrese la dirección de correo electronico">
                    </div>
                    <div class="text-center">
                    	<button type="submit" class="btn btn-primary" id="btnsubmit">Enviar Correo</button>
                    </div>
                </form>
            </div>
		</div>
	</div>
    <?php
    require_once ("../html/mainJs/js.php");
    ?>
    
    <script src="site.js"></script>
</body>
</html>