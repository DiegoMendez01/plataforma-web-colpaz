<?php

require_once("../../config/connection.php");
require_once("../../models/Roles.php");

if(isset($_SESSION['id'])){
    if(!empty($_GET['id'])){
        $roles      = new Roles(); // Asegúrate de que la clase Campuses tenga un método getCampusById() definido
        $roleData   = $roles->getRolesById($_GET['id']);
?>
<!DOCTYPE html>
<html>
<head lang="es">
    <?php
    require_once ("../html/mainHead/head.php");
    ?>
    <title>Aula Virtual::Rol <?= $roleData['name'] ?></title>
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
