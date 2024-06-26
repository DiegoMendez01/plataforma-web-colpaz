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
    <title>Aula Virtual::Gestion de Encabezado Contenidos</title>
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
							<h3>Gestion Encabezado Contenido</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="../home/">Inicio</a></li>
								<li class="active">Gestion Encabezado Contenido</li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			
			<div class="box-typical box-typical-padding">
				<table id="header_content_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
					<thead>
						<tr>
							<th style="width: 30%;">´Profesor</th> 
							<th style="width: 30%;">Creado</th> 
							<th class="d-none d-sm-table-cell" style="width: 25%;">Estado</th>
							<th class="text-center" style="width: 5%"></th>
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
    require_once("../contents/modalGestionHeaderContent.php");
    ?>
    
    <?php
    require_once ("../html/js.php");
    ?>
    <script src="headerContents.js" type="text/javascript"></script>
</body>
</html>
<?php 
}else{
    header("Location:" . Database::route() . "views/404/");
    exit;
}
?>