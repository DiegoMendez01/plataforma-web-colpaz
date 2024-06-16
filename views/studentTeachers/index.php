<?php

require_once("../../config/database.php");

if (isset($_SESSION['id'])) {
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once("../html/head.php"); ?>
    <title>Aula Virtual:Gestion de Estudiantes Profesor</title>
</head>

<body class="with-side-menu">

    <?php require_once("../html/header.php"); ?>
    <div class="mobile-menu-left-overlay"></div>
    <?php require_once("../html/menu.php"); ?>

    <!-- Contenido  -->
    <div class="page-content">
        <div class="container-fluid">
            <header class="section-header">
                <div class="tbl">
                    <div class="tbl-row">
                        <div class="tbl-cell">
                            <h3>Estudiantes Profesor</h3>
                            <ol class="breadcrumb breadcrumb-simple">
                                <li><a href="../home/">Inicio</a></li>
                                <li class="active">Estudiantes profesor</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </header>
            
            <div class="box-typical box-typical-padding">
                <button type="button" id="btnnuevo" class="btn btn-inline btn-primary">Nuevo Registro</button>
                <table id="studentteacher_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                        <tr>
                            <th style="width: 15%;">Estudiante</th>
                            <th style="width: 15%;">Profesor</th>
                            <th style="width: 20%;">Materia</th>
                            <th style="width: 15%;">Grado</th>
                            <th style="width: 15%;">Periodo</th>
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
    
    <?php
    require_once("mantenimiento.php");
    ?>
    
    <?php require_once ("../html/js.php"); ?>
    
    <script src="studentteachers.js" type="text/javascript"></script>
</body>
</html>

<?php
} else {
    header("Location:" . Database::route() . "views/404/");
    exit;
}
?>
