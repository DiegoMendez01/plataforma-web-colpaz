<?php

require_once("../../config/database.php");
require_once("../../models/Periods.php");

if(isset($_SESSION['id'])){
    if(!empty($_GET['id'])){
        $idr            = $_SESSION['idr'];
        $periods        = new Periods();
        $periodsData    = $periods->getPeriodsById($_GET['id'], $idr);
?>
<!DOCTYPE html>
<html>
<head lang="es">
    <?php
    require_once ("../html/head.php");
    ?>
    <title>Aula Virtual::Sede <?= $periodsData['name'] ?></title>
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
                            <h3>Sede <?= $periodsData['name'] ?> [ID: <?= $periodsData['idr'] ?>]</h3>
                            <ol class="breadcrumb breadcrumb-simple">
                                <li><a href="../classrooms/">Inicio</a></li>
                                <li class="active">Sede <?= $periodsData['name'] ?> [ID: <?= $periodsData['idr'] ?>]</li>
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
                            <td><?= $periodsData['name'] ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Estado</th>
                            <td><?= (($periodsData['is_active']) ? '<span class="label label-success">Activo</span>' : '<span class="label label-danger">Inactivo</span>') ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Creado</th>
                            <td><?= $periodsData['created'] ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Modificado</th>
                            <td><?= $periodsData['modified'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <?php
    require_once ("../html/js.php");
    ?>
    <script src="periods.js" type="text/javascript"></script>
</body>
</html>
<?php
    } else {
        header("Location:" . Database::route() . "views/periods/");
        exit;
    }
} else {
    header("Location:" . Database::route() . "views/404/");
    exit;
}
?>
