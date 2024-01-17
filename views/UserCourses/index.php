<?php

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
