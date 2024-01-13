<?php
<<<<<<< HEAD
require_once("../../config/connection.php");

// Assuming you have a UserCourses class or a similar class to handle course-related functionality
require_once("../../models/UserCourses.php");
$userCourses = new UserCourses();

// Assuming there's a method to fetch user courses, adjust the method name accordingly
$userCoursesData = $userCourses->getUserCourses();

?>

<!DOCTYPE html>
<html>

<head lang="es">
    <!-- Head content remains unchanged -->
</head>

<body>
    <div class="page-center" style="height: 100vh; display: flex; justify-content: center; align-items: center; background-image: url('../../public/img/fondoLogin.png'); background-size: cover; background-repeat: no-repeat;">
        <div class="page-center-in" style="width: 71vh;">
            <div class="container-fluid">
                <div class="user-courses-box">
                    <header class="user-courses-title">Mis Cursos</header>
                    
                    <!-- Display user courses -->
                    <?php foreach ($userCoursesData as $course): ?>
                        <div class="course-item">
                            <h4><?php echo $course['course_name']; ?></h4>
                            <p><?php echo $course['description']; ?></p>
                            <!-- Add more details as needed -->
                        </div>
                    <?php endforeach; ?>

                </div>
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
=======

require_once("../../config/connection.php");


if (isset($_SESSION['id'])) {
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once("../MainHead/head.php"); ?>
    <title>Aula Virtual::Cursos Usuarios</title>
</head>

<body class="with-side-menu">

    <?php require_once("../MainHeader/header.php"); ?>
    <div class="mobile-menu-left-overlay"></div>
    <?php require_once("../MainNav/nav.php"); ?>

    <!-- Contenido  -->
    <div class="page-content">
        <div class="container-fluid">
            <header class="section-header">
                <div class="tbl">
                    <div class="tbl-row">
                        <div class="tbl-cell">
                            <h3>Cursos Usuarios</h3>
                            <ol class="breadcrumb breadcrumb-simple">
                                <li><a href="../Home/">Inicio</a></li>
                                <li class="active">Cursos Usuarios</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </header>
            
            <div class="box-typical box-typical-padding">
                <button type="button" id="btnnuevo" class="btn btn-inline btn-primary">Nuevo Registro</button>
                <table id="usercourse_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                        <tr>
                            <th style="width: 15%;">Curso</th>
                            <th style="width: 30%;">Usuario</th>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Estado</th>
                            <th class="text-center" style="width: 5%"></th>
                            <th class="text-center" style="width: 5%"></th>
                            <th class="text-center" style="width: 5%"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    
    <?php require_once("modalGestionUserCourse.php"); ?>
    
    <?php require_once ("../MainJs/js.php"); ?>
    
    <script src="usercourses.js" type="text/javascript"></script>
</body>
</html>

<?php
} else {
    header("Location:" . Connect::route() . "views/login/");
    exit;
}
?>
>>>>>>> 89d1227c4f010e0c38cf0361d5b11625235495cb
