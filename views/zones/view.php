<?php
// Incluye la conexion
require_once("../../config/connection.php");

// Verifica la sesion del usuario
if(isset($_SESSION['id'])){
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("../html/mainHead/head.php"); ?>
    <title>Aula Virtual::Gestion de Zonas</title>
</head>
<body class="with-side-menu">

    <?php require_once("../html/mainHeader/header.php"); ?>
    <div class="mobile-menu-left-overlay"></div>
    <?php require_once("../html/mainNav/nav.php"); ?>

    <!-- Contenido  -->
    <div class="page-content">
        <div class="container-fluid">
            <header class="section-header">
                <div class="tbl">
                    <div class="tbl-row">
                        <div class="tbl-cell">
                            <h3>Gestion de Zonas</h3>
                            <ol class="breadcrumb breadcrumb-simple">
                                <li><a href="../home/">Inicio</a></li>
                                <li class="active">Gestion de Zonas</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </header>
            
            <div class="box-typical box-typical-padding">
                <button type="button" id="btnnuevo" class="btn btn-inline btn-primary">Nuevo Registro</button>
                <table id="zone_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                        <tr>
                            <th style="width: 15%;">Nombre</th>
                            <th style="width: 15%;">Descripción</th>
                            <th style="width: 15%;">Creado</th> 
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Estado</th>
                            <th class="text-center" style="width: 5%"></th>
                            <th class="text-center" style="width: 5%"></th>
                            <th class="text-center" style="width: 5%"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <?php require_once("modalGestionZone.php"); ?>
    
    <?php require_once ("../html/mainJs/js.php"); ?>
    
    <script src="zones.js" type="text/javascript"></script>
</body>
</html>
<?php 
} else {
    header("Location:" . Connect::route() . "views/404/");
    exit;
}
?>
