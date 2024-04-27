<?php

require_once("../../config/connection.php");
require_once("../../models/Zones.php");

if(isset($_SESSION['id'])){
    if(!empty($_GET['id'])){
        $zone           = new Zones(); // Asegúrate de que la clase Zonas tenga un método getZoneById() definido
        $zoneData       = $zone->getZoneById($_GET['id']);
        ?>
<!DOCTYPE html>
<html>
<head lang="es">
    <?php
    require_once ("../html/head.php");
    ?>
    <title>Aula Virtual::Sede <?= $zoneData['name'] ?></title>
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
                            <h3>Sede <?= $zoneData['name'] ?> [ID: <?= $zoneData['id'] ?>]</h3>
                            <ol class="breadcrumb breadcrumb-simple">
                                <li><a href="../classrooms/">Inicio</a></li>
                                <li class="active">Sede <?= $zoneData['name'] ?> [ID: <?= $zoneData['id'] ?>]</li>
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
                            <td><?= $zoneData['name'] ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Estado</th>
                            <td><?= (($zoneData['is_active']) ? '<span class="label label-success">Activo</span>' : '<span class="label label-danger">Inactivo</span>') ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Creado</th>
                            <td><?= $zoneData['created'] ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Modificado</th>
                            <td><?= $zoneData['modified'] ?></td>
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
        header("Location:" . Connect::route() . "views/periods/");
        exit;
    }
} else {
    header("Location:" . Connect::route() . "views/404/");
    exit;
}
?>
