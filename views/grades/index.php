<?php
// Incluye la conexion y la clase Grades
require_once("../../config/connection.php");
require_once("../models/Grades.php");

// Verifica la sesion del usuario
if(isset($_SESSION['id'])){
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("../mainHead/head.php"); ?>
    <title>Aula Virtual::Gestion de Grados</title>
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
                            <h3>Gestion de Grados</h3>
                            <ol class="breadcrumb breadcrumb-simple">
                                <li><a href="../home/">Inicio</a></li>
                                <li class="active">Gestion de Grados</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </header>
            
            <div class="box-typical box-typical-padding">
                <button type="button" id="btnnuevo" class="btn btn-inline btn-primary">Nuevo Registro</button>
                <table id="grades_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                        <tr>
                            <th style="width: 15%;">Nombre</th> 
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

    <?php require_once("modalGestionGrado.php"); ?>
    <?php require_once ("../mainJs/js.php"); ?>
    <script src="gestiongrados.js" type="text/javascript"></script>
</body>
</html>
<?php 
} else {
    header("Location:" . Connect::route() . "views/login/");
    exit;
}
?>
