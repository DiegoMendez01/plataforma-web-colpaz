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
    <title>Aula Virtual::Contenido Actividad</title>
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
			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Actividad </h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="../home/">Inicio</a></li>
								<li class="active">Actividad</li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
    			<div class="row">
    				<header class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="description-inner bg-light-gray p-3" style="background-color: #f7f7f7; padding: 1rem; border: 1rem;">
                            <strong>Apertura:</strong> martes, 27 de febrero de 2024, 08:59<br>
                            <strong>Cierre:</strong> lunes, 4 de marzo de 2024, 23:59
                            <hr>
                            <div class="row align-items-center">
                            	<div class="col-md-4">
                                	<img class="icon mr-2" alt="Laboratorio II.pdf" title="Laboratorio II.pdf" src="https://agora.unisangil.edu.co/theme/image.php/moove/core/1695081302/f/pdf">
                                	<a target="_blank" href="https://agora.unisangil.edu.co/pluginfile.php/26688/mod_assign/introattachment/0/Laboratorio%20II.pdf" class="mr-2">Laboratorio II.pdf</a>
                                </div>
                                <div class="col-md-8">
                                    <div class="text-muted">9 de agosto de 2023, 11:13</div>
                                </div>
                            </div>
                        </div>
                    </header>
               </div>
			</div>
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