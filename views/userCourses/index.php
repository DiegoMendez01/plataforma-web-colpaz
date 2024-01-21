<?php

require_once("../../config/connection.php");

if (isset($_SESSION['id'])) {
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once("../mainHead/head.php"); ?>
    <title>Aula Virtual::Cursos Usuarios</title>
</head>

<body class="with-side-menu">

    <?php require_once("../mainHeader/header.php"); ?>
    <div class="mobile-menu-left-overlay"></div>
    <?php require_once("../mainNav/nav.php"); ?>

    <!-- Contenido  -->
    <div class="page-content">
        <div class="container-fluid">
            <header class="section-header">
                <div class="tbl">
                    <div class="tbl-row">
                        <div class="tbl-cell">
                            <h3>Cursos Usuarios</h3>
                            <ol class="breadcrumb breadcrumb-simple">
                                <li><a href="../home/">Inicio</a></li>
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
                            <th style="width: 15%;">Materia</th>
                            <th style="width: 15%;">Aula</th>
                            <th style="width: 15%;">Grado</th>
                            <th style="width: 10%;">Periodo</th>
                            <th style="width: 25%;">Usuario</th>
                            <th class="d-none d-sm-table-cell" style="width: 5%;">Estado</th>
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
    
    <?php require_once ("../mainJs/js.php"); ?>
    
    <script src="usercourses.js" type="text/javascript"></script>
</body>
</html>

<?php
} else {
    header("Location:" . Connect::route() . "views/site/");
    exit;
}
?>
