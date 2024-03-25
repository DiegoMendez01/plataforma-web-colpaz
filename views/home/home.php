<?php 

require_once("../../config/connection.php");

if($_SESSION['id']){
?>
<!DOCTYPE html>
<html>
<head lang="es">
	<?php 
	require_once("../html/mainHead/head.php");
	?>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css" >
    <title>Aula Virtual::Inicio</title>
</head>
<body class="with-side-menu">
	
	<?php 
	require_once("../html/mainHeader/header.php");
	?>
	<!--.site-header-->

	<div class="mobile-menu-left-overlay"></div>
	
	<?php 
	require_once("../html/mainNav/nav.php");
	?>
	
	<!-- Contenido  -->
	<div class="page-content">
		<div class="row">
    		<div class="col-md-12">
    			<?php 
                if($_SESSION['role_id'] == 1 OR $_SESSION['role_id'] == 2){
                ?>
                <img src="../../assets/img/school.svg" alt="Imagen Colegio" />
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
	require_once("../html/mainJs/js.php");
	?>
	<!-- Contenido  -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
</body>
</html>
<?php 
}else{
    header("Location:".Connect::route()."views/404/");
    exit;
}
?>
