<?php 

require_once("../../docs/Route.php");
require_once("../../docs/Session.php");

if(isset($_POST['submit']) AND $_POST['submit'] == "si"){
    require_once("../../models/Users.php");
    $user = new Users();
    $user->login();
}

$session = Session::getInstance();

if($session->has('id')){
    header("Location:".Route::route()."");
    exit;
}else{
?>
<!DOCTYPE html>
<html>

<head lang="es">
    <?php
    require_once("../html/head.php");
    ?>
    <title>Aula Virtual::Acceso</title>
</head>

<body>
    <div class="page-center" style="height: 100vh; display: flex; justify-content: center; align-items: center; background-image: url('../../assets/img/fondoLogin.png'); background-size: cover; background-repeat: no-repeat;">
        <div class="page-center-in" style="width: 130vh;">
            <div class="container-fluid" style="background-color: white; padding: 25px; border-radius: 5px;">
            	<div class="row">
            		<div class="col-lg-7 col-md-12 right-column">
                        <form class="sign-box" action="" method="post" id="login_form">
                            <input type="hidden" id="rol_id" name="rol_id" value="1">
                            <div class="sign-avatar">
                                <img src="../../assets/img/avatar-1-128.png" alt="" id="imgtipo">
                            </div>
                            <header class="sign-title" id="lbltitulo">Acceso Usuario</header>
                            <!-- Nos sirve para validar si la clave/documento es incorrecta o los campos vacios
                                 Por medio del modelo Users se valida el case según el valor (1 o 2) que provenga de ese modelo  -->
                            <?php 
                            if(isset($_GET['msg'])){
                                switch($_GET['msg'])
                                {
                                    case "1":
                                    ?>
                                    	<div class="alert alert-danger alert-icon alert-close alert-dismissible fade in" role="alert">
                							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                								<span aria-hidden="true">X</span>
                							</button>
                							<i class="font-icon font-icon-warning"></i>
                							Credenciales incorrectas
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
                							Cuenta no verificada. Por favor debe ingresar a <a href="submitted-email">Validar Cuenta</a>.
                						</div>
                                    <?php
                                        break;
                                    case "4":
                                        ?>
                                    	<div class="alert alert-danger alert-icon alert-close alert-dismissible fade in" role="alert">
                							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                								<span aria-hidden="true">X</span>
                							</button>
                							<i class="font-icon font-icon-warning"></i>
                							La clave de seguridad no coincide con la registrada
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
                        <div class="mt-4 pt-2 text-center" style="margin-top: 1rem;">
                        	<div class="signin-other-title">
                        		<h5 class="mb-3 text-muted fw-medium">- Acceder con -</h5>
                        	</div>
                        	<div class="list-inline mb-0">
                        		<li class="list-inline-item">
                        			<!-- TODO: Boton "Iniciar Sesion con Google" con atributos de date  -->
                        			<div id="g_id_onload"
                        				data-client_id="475852867535-v2q5j4cvif9m46qa5s9a42p2hspf67ih.apps.googleusercontent.com"
                        				data-context="signin"
                        				data-ux_mode="popup"
                        				data-callback="handleCredentialResponse"
                        				data-auto_prompt="false"
                        			></div>
                        			
                        			<!-- TODO: Configuracion del boton de inicio de sesion por Google  -->
                        			<div class="g_id_signin"
                        				data-type="standard"
                        				data-shape="rectangular"
                        				data-theme="outline"
                        				data-text="signin_with"
                        				data-size="large"
                        				data-logo_alignment="left"
                        			>
                        			</div>
                        		</li>
                        	</div>
                        </div>
                  	</div>
                  	<div class="col-lg-5 col-md-12 right-column">
                  	    <div class="d-flex mt-2 text-center">
                  		     <img src="../../assets/img/LogoCOLPAZ.png" alt="Logo">
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
    <?php
	require_once("../html/js.php");
	?>
	<!-- script para cargar la API de Google Sign-in de manera asincrona  -->
	<script src="https://accounts.google.com/gsi/client" async></script>
	<script src="google.js"></script>
</body>

</html>
<?php
}
?>