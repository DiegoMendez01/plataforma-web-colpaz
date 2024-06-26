<?php

require_once("../../config/database.php");

if (isset($_SESSION['id'])) {
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once("../html/head.php"); ?>
    <title>Aula Virtual::Cursos Profesor</title>
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
                            <h3>Cursos Profesor</h3>
                            <ol class="breadcrumb breadcrumb-simple">
                                <li><a href="../home/">Inicio</a></li>
                                <li class="active">Cursos Profesor</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </header>
            
            <div class="box-typical box-typical-padding">
                <button type="button" id="btnnuevo" class="btn btn-inline btn-primary">Nuevo Registro</button>
                <table id="teachercourse_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                        <tr>
                            <th>Materia</th>
                            <th>Aula</th>
                            <th>Grado</th>
                            <th>Periodo</th>
                            <th>Usuario</th>
                            <th>Sede</th>
                            <th class="d-none d-sm-table-cell">Estado</th>
                            <th class="text-center"></th>
                            <th class="text-center"></th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    
    <?php
    require_once("mantenimiento.php");
    require_once("modalAsignCampuse.php");
    ?>
    
    <?php require_once ("../html/js.php"); ?>
    
    <script src="teachercourses.js" type="text/javascript"></script>
</body>
</html>

<?php
} else {
    header("Location:" . Database::route() . "views/404/");
    exit;
}
?>
