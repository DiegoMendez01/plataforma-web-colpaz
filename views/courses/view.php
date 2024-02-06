<?php

require_once("../../config/connection.php");
require_once("../../models/Courses.php");

if(isset($_SESSION['id'])){
    if(!empty($_GET['id'])){
        $course     = new Courses();
        $courseData = $course->getCourseById($_GET['id']);
?>
<!DOCTYPE html>
<html>
<head lang="es">
	<?php
    require_once ("../mainHead/head.php");
    ?>
    <title>Aula Virtual::Curso <?= $courseData['name'] ?></title>
</head>
<body class="with-side-menu">
	
	<?php
    require_once ("../mainHeader/header.php");
    ?>
	<!--.site-header-->

	<div class="mobile-menu-left-overlay"></div>
	
	<?php
    require_once ("../mainNav/nav.php");
    ?>
    
    <!-- Contenido  -->
	<div class="page-content">
		<div class="container-fluid">
			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Curso <?= $courseData['name'] ?> [ID: <?= $courseData['id'] ?>]</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="../courses/">Inicio</a></li>
								<li class="active">Curso <?= $courseData['name'] ?> [ID: <?= $courseData['id'] ?>]</li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			
			<div class="box-typical box-typical-padding">
				<table id="course_view_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <tbody>
                        <tr>
                            <th style="width: 30%;">Nombre</th>
                            <td><?= $courseData['name'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 30%;">Descripción</th>
                            <td><?= $courseData['description'] ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Estado</th>
                            <td><?= (($courseData['is_active']) ?  'Activo' : 'Inactivo') ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Creado</th>
                            <td><?= $courseData['created']?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Modificado</th>
                            <td><?= $courseData['modified']?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Sede</th>
                            <td><?= $courseData['idr'] ?></td>
                        </tr>
                    </tbody>
                </table>
			</div>
		</div>
	</div>
    
    <?php
    require_once("modalGestionCurso.php");
    ?>
    
    <?php
    require_once ("../mainJs/js.php");
    ?>
    <script src="courses.js" type="text/javascript"></script>
</body>
</html>
<?php
    }else{
        header("Location:" . Connect::route() . "views/courses/");
        exit;
    }
}else{
    header("Location:" . Connect::route() . "views/site/");
    exit;
}
?>