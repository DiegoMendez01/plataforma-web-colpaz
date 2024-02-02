<?php 

require_once("../../config/connection.php");

if(isset($_POST['submit']) AND $_POST['submit'] == "si"){
    require_once("../../models/Users.php");
    $user = new Users();
    $user->login();
}

?>

<!DOCTYPE html>
<html>

<head lang="es">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Aula Virtual::Acceso</title>

    <link href="../../public/img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
    <link href="../../public/img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
    <link href="../../public/img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
    <link href="../../public/img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
    <link href="../../public/img/favicon.png" rel="icon" type="image/png">
    <link href="../../public/img/favicon.ico" rel="shortcut icon">

    <link rel="stylesheet" href="../../public/css/separate/pages/login.min.css">
    <link rel="stylesheet" href="../../public/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="../../public/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/main.css">
</head>

<body>
    <div class="page-center" style="height: 100vh; display: flex; justify-content: center; align-items: center; background-image: url('../../public/img/fondoLogin.png'); background-size: cover; background-repeat: no-repeat;">
        <div class="page-center-in" style="width: 130vh;">
            <div class="container-fluid" style="background-color: white; padding: 25px; border-radius: 5px;">
            	<div class="row">
            		<div class="col-lg-7 col-md-12 right-column">
                        <form class="sign-box" action="" method="post" id="login_form">
                            <input type="hidden" id="rol_id" name="rol_id" value="1">
                            <div class="sign-avatar">
                                <img src="../../public/img/avatar-1-128.png" alt="" id="imgtipo">
                            </div>
                            <header class="sign-title" id="lbltitulo">Acceso Usuario</header>
                            <!-- Nos sirve para validar si la clave/documento es incorrecta o los campos vacios
                                 Por medio del modelo Users se valida el case según el valor (1 o 2) que provenga de ese modelo  -->
                            <?php 
                            if(isset($_GET['m'])){
                                switch($_GET['m'])
                                {
                                    case "1":
                                    ?>
                                    	<div class="alert alert-danger alert-icon alert-close alert-dismissible fade in" role="alert">
                							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                								<span aria-hidden="true">X</span>
                							</button>
                							<i class="font-icon font-icon-warning"></i>
                							Documento y/o contraseña incorrectos
                						</div>
                					<?php
                                        break;
                                    case "2":
                                    ?>
                                    	<div class="alert alert-danger alert-icon alert-close alert-dismissible fade in" role="alert">
                							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                								<span aria-hidden="true">X</span>
                							</button>
                							<i class="font-icon font-icon-warning"></i>
                							Los campos estan vacíos
                						</div>
                                    <?php
                                        break;
                                    case "3":
                                        ?>
                                    	<div class="alert alert-danger alert-icon alert-close alert-dismissible fade in" role="alert">
                							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                								<span aria-hidden="true">X</span>
                							</button>
                							<i class="font-icon font-icon-warning"></i>
                							Cuenta no verificada. Por favor debe ingresar a <a href="submitted.php">Validar Cuenta</a>.
                						</div>
                                    <?php
                                        break;
                                }
                            }
                            ?>
                            <div class="form-group">
                                <input type="text" id="identification" name="identification" class="form-control" placeholder="Documento de identidad" />
                            </div>
                            <div class="form-group">
                                <input type="password" id="password_hash" name="password_hash" class="form-control" placeholder="Clave de seguridad" />
                            </div>
                            <div class="form-group">
                                <div class="float-right reset">
                                    <a href="#">Cambiar contraseña</a>
                                </div>
                            </div>
                            <input type="hidden" name="submit" class="form-control" value="si">
                            <div class="form-group" style="display: flex; justify-content: center; align-items: center;">
                                <button id="btnacceder" type="submit" class="btn btn-primary">Acceder</button>
                            </div>
                            <div class="form-group" style="display: flex; justify-content: center; align-items: center; ">
                                <a href="../register/" id="btnregistrar ">Registrar cuenta</a>
                            </div>
                        </form>
                  	</div>
                  	<div class="col-lg-5 col-md-12 right-column">
                  	    <div class="d-flex mt-2 text-center">
                  		     <img src="../../public/img/LogoCOLPAZ.png" alt="Logo">
                  		</div>
                        <div class="column-content" style="background-color: white; padding: 20px;">
                            <p style="text-align: center; font-size: 1.5rem;">Docente COLPAZ, solicite sus cursos&nbsp;
                                <a style="font-size: 1.5rem; background-color: #ffffff; text-align: left;" href="https://docs.google.com/forms/d/e/1FAIpQLScHl84AR4iK2HMYg7hHZ4fSN02j5CqKMoOwM0E_QaBcr4HDUw/viewform" target="_blank" rel="noreferrer noopener">aquí</a>
                            </p>
                            <div class="d-flex mt-2 text-center">
                                <div class="login-languagemenu">
                                    <!-- Resto del código -->
                                </div>
                                <button type="button" class="ml-auto btn btn-link" data-modal="alert" data-modal-title-str="[&quot;cookiesenabled&quot;, &quot;core&quot;]" data-modal-content-str="[&quot;cookiesenabled_help_html&quot;, &quot;core&quot;]">
                                    <i class="fa fa-question-circle"></i> Cookies Notice
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid" style="background-color: white; margin-top: 15px; height: 50px; border-radius: 5px;">
            	<div class="row text-center" style="padding-top: 5px;">
                    <a href="../../" class="btn btn-primary">Volver Atras</a>
                </div>
            </div>
        </div>
    </div>
    <!--.page-center-->

    <script src="../../public/js/lib/jquery/jquery.min.js "></script>
    <script src="../../public/js/lib/tether/tether.min.js "></script>
    <script src="../../public/js/lib/bootstrap/bootstrap.min.js "></script>
    <script src="../../public/js/plugins.js "></script>
    <script type="text/javascript " src="../../public/js/lib/match-height/jquery.matchHeight.min.js "></script>
    <script src="../../public/js/app.js "></script>
</body>

</html>