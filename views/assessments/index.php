<?php

require_once("../../config/connection.php");

if(!empty($_SESSION['id'])){
    if(!empty($_GET['content']) AND !empty($_GET['course'])){

?>
<!DOCTYPE html>
<html>
<head lang="es">
	<?php
    require_once ("../html/mainHead/head.php");
    ?>
    <title>Aula Virtual::Contenido Curso</title>
</head>
<body class="with-side-menu">
	<?php
    require_once ("../html/mainHeader/header.php");
    ?>
	<!--.site-header-->

	<div class="mobile-menu-left-overlay"></div>
	
	<?php
    require_once ("../html/mainNav/nav.php");
    ?>
    
    <!-- Contenido  -->
	<div class="page-content">
		<div class="container-fluid">
		</div>
	</div>
</body>
</html>
<?php
    }else{
        header("Location:" . Connect::route() . "views/home/");
        exit;
    }
}else{
    header("Location:" . Connect::route() . "views/404/");
    exit;
}
?>