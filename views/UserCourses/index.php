<?php 

require_once("../../config/connection.php");

if(isset($_POST['submit']) AND $_POST['submit'] == "si"){
    require_once("../../models/userCoursers.php");
    $user = new userCoursers();
    $user->login();
}

?>

<!DOCTYPE html>
<html>

<head lang="es">
    <!-- Your existing head content -->
</head>

<body>
    <div class="page-center" style="height: 100vh; display: flex; justify-content: center; align-items: center; background-image: url('../../public/img/fondoLogin.png'); background-size: cover; background-repeat: no-repeat;">
        <div class="page-center-in" style="width: 71vh;">
            <div class="container-fluid">
                <form class="sign-box" action="../../path/to/your/php/script.php" method="post" id="login_form">
                    <!-- Your existing form content -->

                    <!-- Move your PHP logic here, replacing the existing switch statement -->
                    <?php 
                    if(isset($_POST['submit']) && $_POST['submit'] == "si") {
                        require_once("../../models/userCoursers.php");
                        $user = new userCoursers();
                        $user->login();
                    }

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
                                    Los campos están vacíos
                                </div>
                                <?php
                                break;
                        }
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
    <!--.page-center-->

    <script src="../../public/js/lib/jquery/jquery.min.js"></script>
    <script src="../../public/js/lib/tether/tether.min.js"></script>
    <script src="../../public/js/lib/bootstrap/bootstrap.min.js"></script>
    <script src="../../public/js/plugins.js"></script>
    <script type="text/javascript" src="../../public/js/lib/match-height/jquery.matchHeight.min.js"></script>
    <script src="../../public/js/app.js"></script>
</body>

</html>
