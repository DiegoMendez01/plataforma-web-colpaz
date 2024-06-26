<?php

require_once("../../docs/Session.php");
require_once("../../docs/Route.php");
require_once("../../models/Assessments.php");
require_once("../../models/DateHelper.php");
require_once("../../models/TeacherCourses.php");
require_once("../../models/Users.php");

$session = Session::getInstance();

if($session->has('id')){
    if(!empty($_GET['content']) AND !empty($_GET['course'])){
        $courseId    = $_GET['course'];
        $contentId   = $_GET['content'];
        $idr         = $session->get('idr');

        $assessment     = new Assessments();
        $teacherCourse  = new TeacherCourses();
        $teacher        = new Users();

        $dataTeacherC   = $teacherCourse->getTeacherCourseById($courseId, $idr);
        $assessments    = $assessment->getAssessments($idr, $contentId);
        $user           = $teacher->getUserById($dataTeacherC['user_id']);
?>
<!DOCTYPE html>
<html>
<head lang="es">
	<?php
    require_once ("../html/head.php");
    ?>
    <title>Aula Virtual::Contenido Actividad</title>
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
							<h3>Actividad </h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="../home/">Inicio</a></li>
								<li class="active">Actividad</li>
							</ol>
						</div>
					</div>
				</div>
			</header>
            <div class="box-typical box-typical-padding">
                <button class="btn btn-success icon-btn" id="btnnuevo">
                    <i class="fa fa-plus"></i> Agregar Nuevo Contenido
                </button>
            </div>
            <?php
            foreach($assessments as $data){
            ?>
			<div class="box-typical box-typical-padding">
    			<div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h2><?= $data['title'] ?></h2>
                        <span><?= $data['comment'] ?></span>
                    </div>
    				<header class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <br>
                        <div class="description-inner bg-light-gray p-3" style="background-color: #f7f7f7; padding: 1rem; border: 1rem; margin-bottom: 1rem;">
                            <strong>Apertura:</strong> <?= DateHelper::formatDate($data['created']) ?><br>
                            <strong>Cierre:</strong> <?= DateHelper::formatDate($data['date_limit']) ?>
                            <hr>
                            <strong>Porcentaje Evaluativo:</strong> <?= $data['percentage'] ?><br>
                            <strong>Docente:</strong> <?= $user['name'].' '.$user['lastname'] ?>
                            <hr>
                            <div class="row align-items-center">
                            	<div class="col-md-4">
                                	<img class="icon mr-2" alt="Taller" title="Taller" src="https://agora.unisangil.edu.co/theme/image.php/moove/core/1695081302/f/pdf">
                                	<a target="_blank" href="BASE_URL<?= $data['file']; ?>" class="mr-2">Taller/Actividad</a>
                                </div>
                                <div class="col-md-8">
                                    <div class="text-muted"><?= DateHelper::formatDate($data['modified']) ?></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Columna para los botones -->
                        <div class="col-md-12">
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-warning icon-btn widget-header-btn mr-2" onclick="editAssessment(<?= $data['id'] ?>)">
                                    <i class="fa fa-edit"></i> Editar
                                </button>
                                <button class="btn btn-danger icon-btn widget-header-btn" onclick="deleteAssessment(<?= $data['id'] ?>)">
                                    <i class="fa fa-trash"></i> Eliminar
                                </button>
                                <a href="#" class="btn btn-primary icon-btn widget-header-btn">
                                    <i class="fa fa-eye"></i> Ver Entregas
                                </a>
                            </div>
                        </div>
                    </header>
               </div>
			</div>
            <?php
            }
            ?>
    	</div>
	</div>
    <?php
    require_once("mantenimiento.php");
    ?>
    <?php
    require_once ("../html/js.php");
    ?>
    <script src="assessment.js" type="text/javascript"></script>
</body>
</html>
<?php
    }else{
        header("Location:" . Route::route() . "views/home/");
        exit;
    }
}else{
    header("Location:" . Route::route() . "views/404/");
    exit;
}
?>