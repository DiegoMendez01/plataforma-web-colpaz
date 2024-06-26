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
    <title>Aula Virtual::Gestion de Usuarios</title>
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
							<h3>Gestion Usuario</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="../home/">Inicio</a></li>
								<li class="active">Gestion Usuario</li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			
			<div class="box-typical box-typical-padding">
				<button type="button" id="btnnuevo" class="btn btn-inline btn-primary">Nuevo Registro</button>
				<table id="user_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
					<thead>
						<tr>
							<th style="width: 15%;">Nombre</th> 
							<th style="width: 15%;">Apellido</th> 
							<th class="d-none d-sm-table-cell" style="width: 15%;">Correo</th>
							<th class="d-none d-sm-table-cell" style="width: 10%;">Identificacion</th>
							<th class="d-none d-sm-table-cell" style="width: 10%;">Rol</th>
							<th class="d-none d-sm-table-cell" style="width: 10%;">Sede</th>
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
    require_once("modalGestionUsuario.php");
    ?>
    
    <?php
    require_once("modalAsignRole.php");
    require_once("modalAsignCampuse.php");
    ?>
    
    <?php
    require_once ("../html/js.php");
    ?>
    <script src="users.js" type="text/javascript"></script>
</body>
</html>
<?php 
}else{
    header("Location:" . Database::route() . "views/404/");
    exit;
}
?>