<?php

require_once("../../config/connection.php");


if (isset($_SESSION['id'])) {
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once("../MainHead/head.php"); ?>
    <title>Aula Virtual::Gestion de Grados</title>
</head>

<body class="with-side-menu">

    <?php require_once("../MainHeader/header.php"); ?>
    <div class="mobile-menu-left-overlay"></div>
    <?php require_once("../MainNav/nav.php"); ?>

    <!-- Contenido  -->
    <div class="page-content">
        <div class="container-fluid">
            <header class="section-header">
                <div class="tbl">
                    <div class="tbl-row">
                        <div class="tbl-cell">
                            <h3>Gestion de Grados</h3>
                            <ol class="breadcrumb breadcrumb-simple">
                                <li><a href="../Home/">Inicio</a></li>
                                <li class="active">Gestion de Grados</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </header>

            <div class="box-typical box-typical-padding">
                <button type="button" id="btnnuevo" class="btn btn-inline btn-primary">Nuevo Registro</button>
                <table id="classroom_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                        <tr>
                            <th style="width: 15%;">Nombre</th>
                            <th style="width: 30%;">Creado</th>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Estado</th>
                            <th class="text-center" style="width: 5%"></th>
                            <th class="text-center" style="width: 5%"></th>
                            <th class="text-center" style="width: 5%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        $userCourses = new userCourses();
                        $gradesData = $userCourses->getGradesData();

                        foreach ($gradesData as $grade) {
                            echo "<tr>";
                            echo "<td>{$grade['name']}</td>";
                            echo "<td>{$grade['created']}</td>";
                            echo "<td class='d-none d-sm-table-cell'>{$grade['status']}</td>";
                           
                            echo "<td class='text-center'></td>";
                            echo "<td class='text-center'></td>";
                            echo "<td class='text-center'></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php require_once("modalGestionClassroom.php"); ?>

    <?php require_once("../MainJs/js.php"); ?>

    <script src="classrooms.js" type="text/javascript"></script>
</body>

</html>

<?php
} else {
    header("Location:" . Connect::route() . "views/login/");
    exit;
}
?>
