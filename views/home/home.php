<?php 

require_once("../../config/connection.php");

if($_SESSION['id']){
?>
<!DOCTYPE html>
<html>
<head lang="es">
	<?php 
	require_once("../mainHead/head.php");
	?>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css" >
    <title>Aula Virtual::Inicio</title>
</head>
<body class="with-side-menu">
	
	<?php 
	require_once("../mainHeader/header.php");
	?>
	<!--.site-header-->

	<div class="mobile-menu-left-overlay"></div>
	
	<?php 
	require_once("../mainNav/nav.php");
	?>
	
	<!-- Contenido  -->
	<div class="page-content">
	</div>
	
	<?php
	require_once("../mainJs/js.php");
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
