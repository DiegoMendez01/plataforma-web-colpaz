<?php

require_once("../../config/database.php");
require_once("../../models/Roles.php");
require_once("../../models/Campuses.php");

if(isset($_SESSION['id'])){
    if(!empty($_GET['id'])){
        $idr = $_SESSION['idr'];

        $roles      = new Roles(); // Asegúrate de que la clase Campuses tenga un método getCampusById() definido
        $campuse    = new Campuses();
        $roleData   = $roles->getRolesById($_GET['id'], $idr);
        if(!empty($roleData)){
            $campuseData = $campuse->getCampuseById($roleData['idr']);
?>
<!DOCTYPE html>
<html>
<head lang="es">
    <?php
    require_once ("../html/head.php");
    ?>
    <title>Aula Virtual::Rol <?= $roleData['name'] ?></title>
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
                            <h3>Rol <?= $roleData['name'] ?> [ID: <?= $roleData['id'] ?>]</h3>
                            <ol class="breadcrumb breadcrumb-simple">
                                <li><a href="../campuses/">Inicio</a></li>
                                <li class="active">Sede <?= $roleData['name'] ?> [ID: <?= $roleData['id'] ?>]</li>
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
                            <td><?= $roleData['name'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 30%;">Funciones</th>
                            <td><?= $roleData['functions'] ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Estado</th>
                            <td><?= (($roleData['is_active']) ? '<span class="label label-success">Activo</span>' : '<span class="label label-danger">Inactivo</span>') ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Creado</th>
                            <td><?= $roleData['created'] ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Modificado</th>
                            <td><?= $roleData['modified'] ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Sede</th>
                            <td><span class="label label-primary"><?= ($campuseData) ? $campuseData['name'] : 'General' ?></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <?php
    require_once ("../html/js.php");
    ?>
    <script src="campuses.js" type="text/javascript"></script>
</body>
</html>
<?php
        }else{
            header("Location:" . Database::route() . "views/roles/");
            exit;
        }
    } else {
        header("Location:" . Database::route() . "views/roles/");
        exit;
    }
} else {
    header("Location:" . Database::route() . "views/404/");
    exit;
}
?>
