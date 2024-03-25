<?php

require_once("../../config/connection.php");
require_once("../../models/Users.php"); 
require_once("../../models/Campuses.php");

if(isset($_SESSION['id'])){
    if(!empty($_GET['id'])){
        $user         = new Users(); 
        $campuse      = new Campuses();
        $userData     = $user->getUserById($_GET['id']);
        $campuseData  = $campuse->getCampuseById($userData['idr']);
?>
<!DOCTYPE html>
<html>
<head lang="es">
	<?php
    require_once ("../html/mainHead/head.php");
    ?>
    <title>Aula Virtual::Usuario <?= $userData['name'] ?></title>
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
							<h3>Usuario <?= $userData['name'] ?> [ID: <?= $userData['id'] ?>]</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="../users/">Inicio</a></li>
								<li class="active">Usuario <?= $userData['name'] ?> [ID: <?= $userData['id'] ?>]</li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			
			<div class="box-typical box-typical-padding">
				<table id="user_view_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <tbody>
                        <tr>
                            <th style="width: 30%;">Nombre</th>
                            <td><?= $userData['name'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 30%;">Correo</th>
                            <td><?= $userData['email'] ?></td>
                        </tr>
                        
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Estado</th>
                            <td><?= (($userData['is_active']) ? '<span class="label label-success">Activo</span>' : '<span class="label label-danger">Inactivo</span>') ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Creado</th>
                            <td><?= $userData['created'] ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Modificado</th>
                            <td><?= $userData['modified'] ?></td>
                        </tr>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 25%;">Sede</th>
                            <td><span class="label label-primary"><?= $campuseData['name'] ?></span></td>
                        </tr>
                    </tbody>
                </table>
			</div>
		</div>
	</div>
    
    <?php
    require_once("modalGestionUsuario.php");
    ?>
    
    <?php
    require_once ("../html/mainJs/js.php");
    ?>
    <script src="users.js" type="text/javascript"></script>
</body>
</html>
<?php
    }else{
        header("Location:" . Connect::route() . "views/users/");
        exit;
    }
}else{
    header("Location:" . Connect::route() . "views/site/");
    exit;
}
?>
