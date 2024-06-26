<?php

require_once("../../models/Degrees.php");
require_once("../../docs/Route.php");
require_once("../../docs/Session.php");

$session = Session::getInstance();

if($session->has('id')){
    if(!empty($_GET['id'])){
        $degrees     = new Degrees();
        $degree      = $degrees->getDegreeById($_GET['id']);
        if(!empty($degree)){
?>
<!DOCTYPE html>
<html>
<head lang="es">
	<?php
    require_once ("../html/head.php");
    ?>
    <title>Aula Virtual::Grado <?= $degree['name'] ?></title>
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
							<h3>Curso <?= $degree['name'] ?> [ID: <?= $degree['id'] ?>]</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="../courses/">Inicio</a></li>
								<li class="active">Curso <?= $degree['name'] ?> [ID: <?= $degree['id'] ?>]</li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			
			<div class="box-typical box-typical-padding">
				<table id="course_view_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <tbody>
                        <tr>
                            <th style="width: 30%;">Nombre</th>
                            <td><?= $degree['name'] ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Estado</th>
                            <td><?= (($degree['is_active']) ?  '<span class="label label-success">Activo</span>' : '<span class="label label-danger">Inactivo</span>') ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Creado</th>
                            <td><?= $degree['created']?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Modificado</th>
                            <td><?= $degree['modified']?></td>
                        </tr>
                    </tbody>
                </table>
			</div>
		</div>
	</div>
    
    <?php
    require_once("mantenimiento.php");
    ?>
    
    <?php
    require_once ("../html/js.php");
    ?>
    <script src="degrees.js" type="text/javascript"></script>
</body>
</html>
<?php
        }else{
            header("Location:" . Route::route() . "views/degrees/");
            exit;
        }
    }else{
        header("Location:" . Route::route() . "views/degrees/");
        exit;
    }
}else{
    header("Location:" . Route::route() . "views/404/");
    exit;
}
?>