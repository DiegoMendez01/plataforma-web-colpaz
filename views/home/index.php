<?php 

require_once("../../config/database.php");

if($_SESSION['id']){
?>
<!DOCTYPE html>
<html>
<head lang="es">
	<?php 
	require_once("../html/head.php");
	?>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css" >
    <title>Aula Virtual::Inicio</title>
</head>
<body class="with-side-menu">
	
	<?php 
	require_once("../html/header.php");
	?>
	<!--.site-header-->

	<div class="mobile-menu-left-overlay"></div>
	
	<?php 
	require_once("../html/menu.php");
	?>
	
	<!-- Contenido  -->
	<div class="page-content">
		<div class="row">
    		<div class="col-md-12">
    			<?php 
                if($_SESSION['role_id'] == 1 OR $_SESSION['role_id'] == 2){
                    require_once("../../models/Dashboard.php");
                    $dashboard = new Dashboard();
                ?>
                <div class="row">
                    <div class="col-sm-6 col-lg-3">
                        <article class="statistic-box purple">
                            <div>
                                <?php 
                                $totalUsuarios = $dashboard->countTable('users');
                                ?>
                                <div class="number"><?php echo $totalUsuarios['total']; ?></div>
                                <div class="caption"><div>Total de Usuarios</div></div>
                            </div>
                        </article>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <article class="statistic-box yellow">
                            <div>
                                <?php 
                                $totalCursos = $dashboard->countTable('courses');
                                ?>
                                <div class="number"><?php echo $totalCursos['total']; ?></div>
                                <div class="caption"><div>Total de Cursos</div></div>
                            </div>
                        </article>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <article class="statistic-box green">
                            <div>
                                <?php 
                                $totalMaterias = $dashboard->countTable('zones');
                                ?>
                                <div class="number"><?php echo $totalMaterias['total']; ?></div>
                                <div class="caption"><div>Total de Zonas</div></div>
                            </div>
                        </article>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <article class="statistic-box blue" style="background-color: #357CA5; color: #fff;">
                            <div>
                                <?php 
                                $totalGrados = $dashboard->countTable('degrees');
                                ?>
                                <div class="number"><?php echo $totalGrados['total']; ?></div>
                                <div class="caption"><div>Total de Grados</div></div>
                            </div>
                        </article>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <article class="statistic-box red">
                            <div>
                                <?php 
                                $totalAulas = $dashboard->countTable('classrooms');
                                ?>
                                <div class="number"><?php echo $totalAulas['total']; ?></div>
                                <div class="caption"><div>Total de Aulas</div></div>
                            </div>
                        </article>
                    </div>
                </div>
                <?php 
                }elseif($_SESSION['role_id'] == 3){
                    require_once("../../models/TeacherCourses.php");
                    
                    $teacherCourse   = new TeacherCourses();
                    $dataAll         = $teacherCourse->getTeacherCourseByIdUser($_SESSION['id']);
                    
                    if($dataAll['row'] > 0){
                        while($data = $dataAll['query']->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <div class="col-md-4 text-center border mt-3 p-4 bg-light">
                                <div class="card m-3 shadow" style="height: 350px;">
                                    <img src="../../assets/img/LogoCOLPAZ.png" alt="Logo curso">
                                    <div class="card-body">
                                        <h4 class="card-title text-center"><?php echo $data['nameCourse'] ?></h4>
                                        <h5 class="card-title">Grado <kbd class="bg-info"><?php echo $data['nameDegree'] ?></kbd> - Aula <kbd class="bg-info"><?php echo $data['nameClassroom'] ?></kbd></h5>
                                        <a href="../contents/index?course=<?= $data['id'] ?>" class="btn btn-primary">Acceder</a>
                                        <a href="#" class="btn btn-warning">Ver Alumnos</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                ?>
                <?php
                }elseif($_SESSION['role_id'] == 5){
                ?>
                <header class="section-header">
    				<div class="tbl">
    					<div class="tbl-row">
    						<div class="tbl-cell">
    							<h3>Inicio</h3>
    							<ol class="breadcrumb breadcrumb-simple">
    								<li><a href="../home/">Inicio</a></li>
    								<li class="active">Inicio</li>
    							</ol>
    						</div>
    					</div>
    				</div>
				</header>
				<div class="container mt-5">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <section class="section-header text-center mb-4">
                                <h2 class="display-4">¡Bienvenido a la Plataforma!</h2>
                                <p class="lead">Estamos encantados de tenerte como parte de nuestra comunidad.</p>
                            </section>
                            <div class="alert alert-info" role="alert">
                                <p class="mb-0">¡Bienvenido! Parece que eres un usuario con un rol que requiere confirmación. Por favor, envía un correo electrónico para confirmar tu rol al administrador de la plataforma.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
                }
                ?>
			</div>
		</div>
	</div>
	
	<?php
	require_once("../html/js.php");
	?>
	<!-- Contenido  -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
</body>
</html>
<?php 
}else{
    header("Location:".Database::route()."views/404/");
    exit;
}
?>
