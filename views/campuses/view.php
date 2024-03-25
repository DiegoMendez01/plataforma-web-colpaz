<?php

require_once("../../config/connection.php");
require_once("../../models/Campuses.php");

if(isset($_SESSION['id'])){
    if(!empty($_GET['id'])){
        $campus       = new Campuses(); // Asegúrate de que la clase Campuses tenga un método getCampusById() definido
        $campusData   = $campus->getCampuseById($_GET['id']);
?>
<!DOCTYPE html>
<html>
<head lang="es">
    <?php
    require_once ("../html/mainHead/head.php");
    ?>
    <title>Aula Virtual::Sede <?= $campusData['name'] ?></title>
</head>
<body class="with-side-menu">
    
    <?php
    require_once ("../html/mainHeader/header.php");
    ?>
    <!--.site-header-->

    <div class="mobile-menu-left-overlay"></div>
    
    <?php
    require_once ("../html/mainNav/nav.php");
    ?>
    
    <!-- Contenido  -->
    <div class="page-content">
        <div class="container-fluid">
            <header class="section-header">
                <div class="tbl">
                    <div class="tbl-row">
                        <div class="tbl-cell">
                            <h3>Sede <?= $campusData['name'] ?> [ID: <?= $campusData['idr'] ?>]</h3>
                            <ol class="breadcrumb breadcrumb-simple">
                                <li><a href="../campuses/">Inicio</a></li>
                                <li class="active">Sede <?= $campusData['name'] ?> [ID: <?= $campusData['idr'] ?>]</li>
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
                            <td><?= $campusData['name'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 30%;">Descripcion</th>
                            <td><?= $campusData['description'] ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Estado</th>
                            <td><?= (($campusData['is_active']) ? '<span class="label label-success">Activo</span>' : '<span class="label label-danger">Inactivo</span>') ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Creado</th>
                            <td><?= $campusData['created'] ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Modificado</th>
                            <td><?= $campusData['modified'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <?php
    require_once ("../html/mainJs/js.php");
    ?>
    <script src="campuses.js" type="text/javascript"></script>
</body>
</html>
<?php
    } else {
        header("Location:" . Connect::route() . "views/campuses/");
        exit;
    }
} else {
    header("Location:" . Connect::route() . "views/site/");
    exit;
}
?>
