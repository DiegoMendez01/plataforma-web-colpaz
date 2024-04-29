<?php

require_once("../../config/database.php");

if(isset($_SESSION['id'])){
?>
<!DOCTYPE html>
<html>
<head lang="es">
	<?php
    require_once ("../html/head.php");
    ?>
    <title>Aula Virtual::Gestion de Cursos</title>
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
							<h3>Gestion Curso</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="../home/">Inicio</a></li>
								<li class="active">Gestion Curso</li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			
			<div class="box-typical box-typical-padding">
				<button type="button" id="btnnuevo" class="btn btn-inline btn-primary">Nuevo Registro</button>
				<table id="course_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
					<thead>
						<tr>
							<th>Nombre</th> 
							<th>Descripcion</th>
							<th>Sede</th>
							<th>Estado</th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				 </table>
			</div>
		</div>
	</div>
    
    <?php
    require_once("modalGestionCurso.php");
    ?>
    
    <?php
    require_once ("../html/js.php");
    ?>
    <script src="courses.js" type="text/javascript"></script>
</body>
</html>
<?php 
}else{
    header("Location:" . Database::route() . "views/404/");
    exit;
}
?>