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
    <title>Aula Virtual:Correo Electronico Enviado</title>
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
    
    <?php
    require_once("submitted-email.php");
    ?>
    
    <?php
    require_once ("../mainJs/js.php");
    ?>
    <script src="submitted-email.js" type="text/javascript"></script>
</body>
</html>
<?php 
}else{
    header("Location:" . Connect::route() . "views/site/");
    exit;
}
?>