<?php

require_once("../../config/database.php");
require_once("../../models/HeaderContents.php");
require_once("../../models/TeacherCourses.php");
require_once("../../models/Campuses.php");
require_once("../../models/Users.php");

if(isset($_SESSION['id'])){
    if(!empty($_GET['id'])){
        $idr            = $_SESSION['idr'];
        $HeaderContent  = new HeaderContents();
        $teacherCourse  = new TeacherCourses();
        $user           = new Users();
        $campuse        = new Campuses();
        $headerData     = $HeaderContent->getHeaderContentById($_GET['id'], $idr);
        $teacherCData   = $teacherCourse->getTeacherCourseById($headerData['teacher_course_id'], $idr);
        $userData       = $user->getUserById($teacherCData['user_id']);
        $campuseData    = $campuse->getCampuseById($headerData['idr']);
?>
<!DOCTYPE html>
<html>
<head lang="es">
	<?php
    require_once ("../html/head.php");
    ?>
    <title>Aula Virtual::Encabezado de Contenido <?= $headerData['id'] ?></title>
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
							<h3>Encabezado de Contenido de <?= $userData['name'].' '.$userData['lastname'] ?> [ID: <?= $headerData['id'] ?>]</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="../headerContents/">Inicio</a></li>
								<li class="active">Encabezado de Contenido de <?= $userData['name'].' '.$userData['lastname'] ?> [ID: <?= $headerData['id'] ?>]</li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			
			<div class="box-typical box-typical-padding">
				<table id="course_view_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <tbody>
                        <tr>
                            <th style="width: 30%;">Profesor</th>
                            <td><?= $userData['name'].' '.$userData['lastname'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 30%;">Video</th>
                            <td>
                                <?php if (empty($headerData['header_video'])): ?>
                                    No Disponible
                                <?php else: ?>
                                    <a href="<?= $headerData['header_video'] ?>" class="btn btn-primary" target="_blank">Ver Video</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Archivo Plan Estudios</th>
                            <td>
                                <a href="../<?= $headerData['curriculum_file'] ?>" class="btn btn-primary" download>Descargar Plan de Estudios</a>
                            </td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Archivo Informacion Extra</th>
                            <td>
                                <a href="../<?= $headerData['supplementary_file'] ?>" class="btn btn-primary" download>Descargar Información Extra</a>
                            </td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Estado</th>
                            <td><?= (($headerData['is_active']) ?  '<span class="label label-success">Activo</span>' : '<span class="label label-danger">Inactivo</span>') ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Creado</th>
                            <td><?= $headerData['created']?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Modificado</th>
                            <td><?= $headerData['modified']?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Sede</th>
                            <td><span class="label label-primary"><?= $campuseData['name'] ?></span></td>
                        </tr>
                    </tbody>
                </table>
			</div>
		</div>
	</div>
    
    <?php
    require_once ("../html/js.php");
    ?>
    <script src="courses.js" type="text/javascript"></script>
</body>
</html>
<?php
    }else{
        header("Location:" . Database::route() . "views/headerContents/");
        exit;
    }
}else{
    header("Location:" . Database::route() . "views/404/");
    exit;
}
?>