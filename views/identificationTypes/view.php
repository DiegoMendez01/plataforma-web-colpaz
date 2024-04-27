<?php

require_once("../../config/connection.php");
require_once("../../models/IdentificationTypes.php");
require_once("../../models/Campuses.php");

if(isset($_SESSION['id'])){
    if(!empty($_GET['id'])){
        $identificationType      = new IdentificationTypes();
        $campuse                 = new Campuses();
        $identificationTypeData  = $identificationType->getIdentificationTypeById($_GET['id']);
        $campuseData             = $campuse->getCampuseById($identificationTypeData['idr']);
?>
<!DOCTYPE html>
<html>
<head lang="es">
	<?php
    require_once ("../html/head.php");
    ?>
    <title>Aula Virtual::Curso <?= $identificationTypeData['name'] ?></title>
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
							<h3>Tipo Identificacion <?= $identificationTypeData['name'] ?> [ID: <?= $identificationTypeData['id'] ?>]</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="../identificationTypes/">Inicio</a></li>
								<li class="active">Tipo Identificacion <?= $identificationTypeData['name'] ?> [ID: <?= $identificationTypeData['id'] ?>]</li>
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
                            <td><?= $identificationTypeData['name'] ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Estado</th>
                            <td><?= (($identificationTypeData['is_active']) ?  '<span class="label label-success">Activo</span>' : '<span class="label label-danger">Inactivo</span>') ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Creado</th>
                            <td><?= $identificationTypeData['created']?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Modificado</th>
                            <td><?= $identificationTypeData['modified']?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Sede</th>
                            <td><span class="label label-primary"><?= (($identificationTypeData['idr'] == 0) ? 'Sede General' : $campuseData['name']) ?></span></td>
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
    <script src="identificationType.js" type="text/javascript"></script>
</body>
</html>
<?php
    }else{
        header("Location:" . Connect::route() . "views/identificationTpes/");
        exit;
    }
}else{
    header("Location:" . Connect::route() . "views/404/");
    exit;
}
?>