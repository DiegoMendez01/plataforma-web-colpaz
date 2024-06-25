<?php

require_once("../../config/database.php");
require_once("../../models/Studentteachers.php");
require_once("../../models/Users.php");
require_once("../../models/Periods.php");
require_once("../../models/Campuses.php");

if(isset($_SESSION['id'])){
    if(!empty($_GET['id'])){
        $idr                 = $_SESSION['idr'];

        $campuse             = new Campuses();
        $studentTeachers     = new StudentTeachers();
        $users               = new Users();
        $periods             = new Periods();

        $studentTeacher      = $studentTeachers->getStudentTeacherById($_GET['id'], $idr);
        $student             = $users->getUserById($studentTeacher['user_id']);
        $teacher             = $users->getUserById($studentTeacher['teacher_course_id']);
        $period              = $periods->getPeriodsById($studentTeacher['period_id'], $idr);
        $campuseData         = $campuse->getCampuseById($studentTeacher['idr']);
?>
<!DOCTYPE html>
<html>
<head lang="es">
	<?php
    require_once ("../html/head.php");
    ?>
    <title>Aula Virtual::Alumno  <?= $student['name'] ?></title>
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
							<h3>Alumno <?= $student['name'] ?> [ID: <?= $studentTeacher['id'] ?>]</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="../studentTeachers/">Inicio</a></li>
								<li class="active">Alumno <?= $student['name'] ?> [ID: <?= $studentTeacher['id'] ?>]</li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			
			<div class="box-typical box-typical-padding">
				<table id="studentteacher_view_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <tbody>
                        <tr>
                            <th style="width: 30%;">Estudiante</th>
                            <td><?= $student['name'].' '.$student['lastname'] ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Profesor</th>
                            <td><?= $teacher['name'].' '.$teacher['lastname'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 30%;">Periodo</th>
                            <td><?= $period['name'] ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Estado</th>
                            <td><?= (($studentTeacher['is_active']) ?  '<span class="label label-success">Activo</span>' : '<span class="label label-danger">Inactivo</span>') ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Creado</th>
                            <td><?= $studentTeacher['created']?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Modificado</th>
                            <td><?= $studentTeacher['modified']?></td>
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
    require_once("mantenimiento.php");
    ?>
    
    <?php
    require_once ("../html/js.php");
    ?>
    <script src="studentteacher.js" type="text/javascript"></script>
</body>
</html>
<?php
    }else{
        header("Location:" . Database::route() . "views/studentteacher/");
        exit;
    }
}else{
    header("Location:" . Database::route() . "views/404/");
    exit;
}
?>