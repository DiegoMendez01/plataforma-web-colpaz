<?php
require_once("../../config/connection.php");

if(!empty($_GET['course']) AND isset($_SESSION['id'])){
    $courseId = $_GET['course'];
    
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
							<h3>Gestion Curso <?= $courseId ?></h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="../home/">Inicio</a></li>
								<li class="active">Gestion Curso <?= $courseId ?></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			
			<div class="box-typical box-typical-padding">
				<button type="button" id="btnnuevo" class="btn btn-inline btn-primary">Nuevo Registro</button>
			</div>
			
			<div class="col-md-12">
			</div>
		</div>
	</div>
    
    <?php
    require_once("modalGestionContenido.php");
    ?>
    
    <?php
    require_once ("../mainJs/js.php");
    ?>
    <script src="contents.js" type="text/javascript"></script>
</body>
</html>
<?php 
}else{
    header("Location:" . Connect::route() . "views/site/");
    exit;
}
?>