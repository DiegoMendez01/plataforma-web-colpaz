<?php

require_once("../../config/connection.php");
require_once("../../models/Contents.php");
require_once("../../models/Courses.php");
require_once("../../models/TeacherCourses.php");
require_once("../../models/Classrooms.php");
require_once("../../models/HeaderContents.php");

if(!empty($_SESSION['id'])){
    if(!empty($_GET['course']) AND isset($_SESSION['id'])){
        $courseId          = $_GET['course'];
        
        $content           = new Contents();
        $teacherCourse     = new TeacherCourses();
        $course            = new Courses();
        $classroom         = new Classrooms();
        $headerContent     = new HeaderContents();
        
        $dataTeacherC      = $teacherCourse->getTeacherCourseById($courseId);
        $dataCourse        = $course->getCourseById($dataTeacherC['course_id']);
        $dataHeaderC       = $headerContent->getHeaderContentByTeacher($dataTeacherC['id']);
        $dataClassroom     = $classroom->getClassroomById($dataTeacherC['classroom_id']);
        $dataAllContent    = $content->getContentByTeacherCourseId($dataTeacherC['course_id']);
?>
<!DOCTYPE html>
<html>
<head lang="es">
	<?php
    require_once ("../mainHead/head.php");
    ?>
    <title>Aula Virtual::Contenido Curso <?= $courseId ?></title>
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
							<h3>Curso <?= $dataCourse['name'] ?></h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="../home/">Inicio</a></li>
								<li class="active">Curso <?= $dataCourse['name'] ?></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			
			<div class="box-typical box-typical-padding">
				<button type="button" id="btnnuevo" class="btn btn-inline btn-primary">Nuevo Registro</button>
			</div>
			<div class="box-typical box-typical-padding">
    			<div class="text-center" style="margin-bottom: 1rem;">
    				<img src="../../public/img/bienvenidaf.png" alt="Logo bienvenida">
    			</div>
    			<p>En este espacio académico se van a tratar los temas relacionados con <?= $dataCourse['name'] ?> del grado <?= $dataClassroom['name'] ?></p>
    			<img style="width: 17rem; height: 3rem;" src="../../public/img/acerca_asignatura.png" alt="Logo acerca de">
    			<?php
    			if(!empty($dataHeaderC['id']) AND $dataHeaderC['is_active'] == 1){
        			if(!empty($dataHeaderC['curriculum_file'])){
        			?>
        			<div class="col-md-12" style="margin-top: 2rem;">
        				<img src="../../public/img/icon_file.png" alt="resource icon">
                        <a href="#" target="_blank">
                            <i class="fa fa-download"></i> Plan de Estudios
                        </a>
        			</div>
        			<?php
        			}
        			if(!empty($dataHeaderC['supplementary_file'])){
        			    ?>
        			<div class="col-md-12" style="margin-top: 1rem; margin-bottom: 3rem;">
        				<img src="../../public/img/icon_file.png" alt="resource icon">
                        <a href="#" target="_blank">
                            <i class="fa fa-download"></i> Informacion Adicional del Curso
                        </a>
        			</div>
        			<?php
        			}
        			?>
        			<div class="box-typical box-typical-padding">
        				<button type="button" id="btnnuevocontenido" class="btn btn-inline btn-primary">Agregar Contenido</button>
        			</div>
        			<?php
        			if ($dataAllContent['rowContent'] > 0) {
        			    while ($data = $dataAllContent['queryContent']->fetch(PDO::FETCH_ASSOC)) {
        			        ?>
                            <section style="margin-top: 2rem;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span style="font-size: 2rem;" data-toggle="collapse" data-target="#infoCollapse<?= $data['id'] ?>" aria-expanded="false" aria-controls="infoCollapse<?= $data['id'] ?>"><?= $data['title'] ?> </span>
                                    <?php
                                    if($data['status'] == 1){
                                    ?>
                                        <span class="label label-primary">Disponible</span>
                                    <?php
                                    }else{
                                    ?>
                                        <span class="label label-danger">No Disponible</span>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="collapse" id="infoCollapse<?= $data['id'] ?>">
                                    <?php 
                                    if($data['status'] == 1){
                                    ?>
                                    <div class="row align-items-center" style="margin-top: 2rem;">
                                        <!-- Columna para el título -->
                                        <div class="col-md-10">
                                            <h4>
                                                <?= $data['description'] ?>
                                            </h4>
                                        </div>
                                        <!-- Columna para los botones -->
                                        <div class="col-md-2">
                                            <div class="d-flex justify-content-end">
                                                <button class="btn btn-warning icon-btn widget-header-btn mr-2" onclick="editar(<?= $data['id']; ?>)">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button class="btn btn-danger icon-btn widget-header-btn" onclick="eliminar(<?= $data['id']; ?>)">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                <button class="btn btn-danger icon-btn widget-header-btn" onclick="bloquear(<?= $data['id']; ?>)">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-body">
                                        <img style="width: 30rem; height: 4rem; margin-bottom: 2rem; margin-top: 2rem;" src="../../public/img/banner_recursos1.jpg" alt="Logo Recurso">
                                        <div class="d-flex flex-column flex-md-row w-100 align-items-start">
                                            <img src="../../public/img/icon_file.png" alt="resource icon">
                                            <a class="btn" href="#" target="_blank">
                                                <i class="fa fa-download"></i> Material de Descarga
                                            </a>
                                            <?php
                                            if(!empty($data['video'])){
                                            ?>
                                            <!-- Video de YouTube incrustado -->
                                           <div style="margin-top: 2rem;">
                                                <img style="width: 4rem; height: 4rem;" src="../../public/img/miniaturaVideo.png" alt="miniatura del video">
                                                <a style="width: 200px;" class="btn" href="<?= $data['video'] ?>" target="_blank">
                                                	<i class="fa fa-youtube-play"></i> Ver video
                                                </a>
                                            </div>
                                            <?php
        			                         }
                                            ?>
                                        </div>
                                        <img style="width: 30rem; height: 4rem; margin-bottom: 2rem; margin-top: 2rem;" src="../../public/img/banner_actividades1.png" alt="Logo Recurso">
                                        <div class="d-flex flex-column flex-md-row w-100 align-items-start">
                                            <img src="../../public/img/icon_submitted.png" alt="resource icon">
                                            <a class="btn" href="#" target="_blank">
                                                <i class="fa fa-paper-plane"></i> Asignar Evaluacion
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                    }else{
                                    ?>
                                    <div class="row align-items-center" style="margin-top: 2rem;">
                                        <!-- Columna para el título -->
                                        <div class="col-md-10">
                                        </div>
                                        <!-- Columna para los botones -->
                                        <div class="col-md-2">
                                            <div class="d-flex justify-content-end">
                                                <button class="btn btn-warning icon-btn widget-header-btn mr-2" onclick="editar(<?= $data['id']; ?>)">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button class="btn btn-danger icon-btn widget-header-btn" onclick="eliminar(<?= $data['id']; ?>)">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                <button class="btn btn-success icon-btn widget-header-btn" onclick="desbloquear(<?= $data['id']; ?>)">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-body text-center">
                                    	<h2 style="margin-top: 2rem;">El docente ha cerrado la actividad para su visualización.</h2>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </section>
                            <?php
        			     }
        			}
                }
                ?>
    		</div>
		</div>
	</div>
    
    <?php
    require_once("modalGestionContenido.php");
    ?>
    
    <?php
    require_once("modalGestionHeaderContent.php");
    ?>
    
    <?php
    require_once ("../mainJs/js.php");
    ?>
    <script src="contents.js" type="text/javascript"></script>
</body>
</html>
<?php
    }
}else{
    header("Location:" . Connect::route() . "views/site/");
    exit;
}
?>