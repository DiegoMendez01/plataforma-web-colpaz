<?php 

require_once("../../config/connection.php");

if($_SESSION['id']){
?>
<!DOCTYPE html>
<html>
<head lang="es">
	<?php 
	require_once("../MainHead/head.php");
	?>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css" >
    <title>Aula Virtual::Inicio</title>
</head>
<body class="with-side-menu">
	
	<?php 
	require_once("../MainHeader/header.php");
	?>
	<!--.site-header-->

	<div class="mobile-menu-left-overlay"></div>
	
	<?php 
	require_once("../MainNav/nav.php");
	?>
	
	<!-- Contenido  -->
	<div class="page-content">
		<div class="row">
    		<div class="col-md-12">
				<img src="../../public/img/school.svg" alt="Imagen Colegio" />
			</div>
		</div>
	</div>
	
	<?php
	require_once("../MainJs/js.php");
	?>
	<!-- Contenido  -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
</body>
</html>
<?php 
}else{
    header("Location:".Connect::route()."views/login/");
    exit;
}
?>
