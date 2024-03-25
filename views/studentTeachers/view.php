<?php

require_once("../../config/connection.php");
require_once("../../models/Studentteacher.php");
require_once("../../models/Campuses.php");

if(isset($_SESSION['id'])){
    if(!empty($_GET['id'])){
        
        $campuse     = new Campuses();
        $studentteacherData  = $studentteacher->getStudentTeacherById($_GET['id']);
        $campuseData = $campuse->getCampuseById($studentteacherData['idr']);
?>
<!DOCTYPE html>
<html>
<head lang="es">
	<?php
    require_once ("../html/mainHead/head.php");
    ?>
    <title>Aula Virtual::Alumnos y profesores <?= $studentteacherData['name'] ?></title>
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
							<h3>Alumno profesor <?= $studentteacherData['name'] ?> [ID: <?= studentteacherData['id'] ?>]</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="../studentteacher/">Inicio</a></li>
								<li class="active">Alumno profesor <?= studentteacherData['name'] ?> [ID: <?= studentteacherData['id'] ?>]</li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			
			<div class="box-typical box-typical-padding">
				<table id="studentteacher_view_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <tbody>
                        <tr>
                            <th style="width: 30%;">Nombre</th>
                            <td><?= $studentteacherData['name'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 30%;">Periodo</th>
                            <td><?= studentteacherData['description'] ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Estado</th>
                            <td><?= ((studentteacherData['is_active']) ?  '<span class="label label-success">Activo</span>' : '<span class="label label-danger">Inactivo</span>') ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Creado</th>
                            <td><?= $studentteacherData['created']?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Modificado</th>
                            <td><?= studentteacherData['modified']?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Profesor</th>
                            <td><span class="label label-primary"><?= $campuseData['name'] ?></span></td>
                        </tr>
                    </tbody>
                </table>
			</div>
		</div>
	</div>
    
    <?php
    require_once("modalGestionStudentTeacher.php");
    ?>
    
    <?php
    require_once ("../html/mainJs/js.php");
    ?>
    <script src="studentteacher.js" type="text/javascript"></script>
</body>
</html>
<?php
    }else{
        header("Location:" . Connect::route() . "views/studentteacher/");
        exit;
    }
}else{
    header("Location:" . Connect::route() . "views/404/");
    exit;
}
?>