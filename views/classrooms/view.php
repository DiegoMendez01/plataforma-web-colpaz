<?php

require_once("../../config/database.php");
require_once("../../models/Classrooms.php");

if(isset($_SESSION['id'])){
    if(!empty($_GET['id'])){
        $idr              = $_SESSION['idr'];
        $classrooms       = new Classrooms();
        $clasroomsData    = $classrooms->getClassroomById($_GET['id'], $idr);
?>
<!DOCTYPE html>
<html>
<head lang="es">
    <?php
    require_once ("../html/head.php");
    ?>
    <title>Aula Virtual::Sede <?= $clasroomsData['name'] ?></title>
</head>
<body class="with-side-menu">
    
    <?php
    require_once ("../html/header.php");
    ?>
    <!--.site-header-->

    <div class="mobile-menu-left-overlay"></div>
    
    <?php
    require_once ("../html/menu.php");
    ?>
    
    <!-- Contenido  -->
    <div class="page-content">
        <div class="container-fluid">
            <header class="section-header">
                <div class="tbl">
                    <div class="tbl-row">
                        <div class="tbl-cell">
                            <h3>Sede <?= $clasroomsData['name'] ?> [ID: <?= $clasroomsData['idr'] ?>]</h3>
                            <ol class="breadcrumb breadcrumb-simple">
                                <li><a href="../classrooms/">Inicio</a></li>
                                <li class="active">Sede <?= $clasroomsData['name'] ?> [ID: <?= $clasroomsData['idr'] ?>]</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </header>
            
            <div class="box-typical box-typical-padding">
                <table id="campus_view_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <tbody>
                        <tr>
                            <th style="width: 30%;">Nombre</th>
                            <td><?= $clasroomsData['name'] ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Estado</th>
                            <td><?= (($clasroomsData['is_active']) ? '<span class="label label-success">Activo</span>' : '<span class="label label-danger">Inactivo</span>') ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Creado</th>
                            <td><?= $clasroomsData['created'] ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Modificado</th>
                            <td><?= $clasroomsData['modified'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <?php
    require_once ("../html/js.php");
    ?>
    <script src="classrooms.js" type="text/javascript"></script>
</body>
</html>
<?php
    } else {
        header("Location:" . Database::route() . "views/classrooms/");
        exit;
    }
} else {
    header("Location:" . Database::route() . "views/404/");
    exit;
}
?>
