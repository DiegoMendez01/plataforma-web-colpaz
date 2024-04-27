<?php

require_once("../../config/database.php");
require_once("../../models/TeacherCourses.php");
require_once("../../models/Campuses.php");
require_once("../../models/Users.php");
require_once("../../models/Courses.php");
require_once("../../models/Classrooms.php");
require_once("../../models/Degrees.php");
require_once("../../models/Periods.php");

if(isset($_SESSION['id'])){
    if(!empty($_GET['id'])){
        
        $teacherCourse      = new TeacherCourses();
        $campuse            = new Campuses();
        $user               = new Users();
        $degree             = new Degrees();
        $classroom          = new Classrooms();
        $period             = new Periods();
        $course             = new Courses();
        
        $teachercourseData  = $teacherCourse->getTeacherCourseById($_GET['id']);
        $campuseData        = $campuse->getCampuseById($teachercourseData['idr']);
        $userData           = $user->getUserById($teachercourseData['user_id']);
        $periodData         = $period->getPeriodsById($teachercourseData['period_id']);
        $degreeData         = $degree->getDegreeById($teachercourseData['degree_id']);
        $classroomData      = $classroom->getClassroomById($teachercourseData['classroom_id']);
        $courseData         = $course->getCourseById($teachercourseData['course_id']);
?>
<!DOCTYPE html>
<html>
<head lang="es">
	<?php
    require_once ("../html/head.php");
    ?>
    <title>Aula Virtual::Cursos Profesor <?= $userData['name'] ?></title>
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
							<h3>Curso profesor <?= $userData['name'].' '.$userData['lastname'] ?> [ID: <?= $userData['id'] ?>]</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="../teachercourse/">Inicio</a></li>
								<li class="active">Curso profesor <?= $userData['name'].' '.$userData['lastname'] ?> [ID: <?= $userData['id'] ?>]</li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			
			<div class="box-typical box-typical-padding">
				<table id="teachercourse_view_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <tbody>
                        <tr>
                            <th style="width: 30%;">Profesor</th>
                            <td><?= $userData['name'].' '.$userData['lastname'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 30%;">Periodo</th>
                            <td><?= $periodData['name'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 30%;">Grado</th>
                            <td><?= $degreeData['name'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 30%;">Aula</th>
                            <td><?= $classroomData['name'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 30%;">Materia</th>
                            <td><?= $courseData['name'] ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Estado</th>
                            <td><?= (($teachercourseData['is_active']) ?  '<span class="label label-success">Activo</span>' : '<span class="label label-danger">Inactivo</span>') ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Creado</th>
                            <td><?= $teachercourseData['created']?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Modificado</th>
                            <td><?= $teachercourseData['modified']?></td>
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
    require_once("modalGestionTeacherCourse.php");
    ?>
    
    <?php
    require_once ("../html/js.php");
    ?>
    <script src="teachercourses.js" type="text/javascript"></script>
</body>
</html>
<?php
    }else{
        header("Location:" . Database::route() . "views/teachercourse/");
        exit;
    }
}else{
    header("Location:" . Database::route() . "views/404/");
    exit;
}
?>