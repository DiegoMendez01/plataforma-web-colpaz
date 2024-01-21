<?php

require_once("../../config/connection.php");

if(isset($_SESSION['id'])){
?>
<!DOCTYPE html>
<html>
<head lang="es">
	<?php
    require_once ("../mainHead/head.php");
    ?>
    <title>Aula Virtual::roles</title>
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
							<h3>Gestion Roles</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="../home/">Inicio</a></li>
								<li class="active">Gestion Roles</li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			
			<div class="box-typical box-typical-padding">
				<button type="button" id="btnnuevo" class="btn btn-inline btn-primary">Nuevo registro</button>
				<table id="role_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
					<thead>
						<tr>
							<th style="width: 15%;">Nombre</th> 
							<th style="width: 20%;">Funciones</th> 
							<th class="d-none d-sm-table-cell" style="width: 15%;">Creado</th>
							<th class="d-none d-sm-table-cell" style="width: 15%;">Estado</th>
							<th class="text-center" style="width: 5%"></th>
							<th class="text-center" style="width: 5%"></th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				 </table>
			</div>
		</div>
	</div>
    
    <?php
    require_once("modalGestionRoles.php");
    ?>
    
    <?php
    require_once ("../mainJs/js.php");
    ?>
    <script src="roles.js" type="text/javascript"></script>
</body>
</html>
<?php 
}else{
    header("Location:" . Connect::route() . "views/site/");
    exit;
}
?>