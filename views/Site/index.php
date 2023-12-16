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
        <div class="page-center-in" style="width: 71vh;">
            <div class="container-fluid">
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
        								<span aria-hidden="true">×</span>
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
        								<span aria-hidden="true">×</span>
        							</button>
        							<i class="font-icon font-icon-warning"></i>
        							Los campos estan vacíos
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
                        <a href="../Register/" id="btnregistrar ">Registrar cuenta</a>
                    </div>
                </form>
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