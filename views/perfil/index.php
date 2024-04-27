<?php
require_once ("../../config/database.php");

if (isset($_SESSION['id'])) {
    ?>

<!DOCTYPE html>
<html>
<head lang="es">
	<?php
    require_once ("../html/head.php");
    ?>
    <title>Aula Virtual::Perfil</title>
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
							<h3>Perfil</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="../home/">Inicio</a></li>
								<li class="active">Perfil de Usuario</li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
    			<div class="row">
                    <div class="col-xl-3 col-lg-4">
                        <section class="box-typical profile-side-user">
                            <button type="button" class="avatar-preview avatar-preview-128">
								<img src="../../public/img/avatar-1-128.png" alt="">
								<span class="update">
									<i class="font-icon font-icon-picture-double"></i>
									Actualizar foto
								</span>
								<input type="file">
							</button>
                            <div class="btn-group">
                            </div>
                        </section>
                        <section class="box-typical">
                            <header class="box-typical-header-sm bordered">Info</header>
                            <div class="box-typical-inner">
                                <p class="line-with-icon">
                                    <i class="font-icon font-icon-user"></i> <?php echo $_SESSION['name'].' '.$_SESSION['lastname'] ?>
                                </p>
                                <p class="line-with-icon">
                                    <i class="font-icon font-icon-user"></i> <?php echo $_SESSION['role_name'] ?>
                                </p>
                                <p class="line-with-icon">
                                    <i class="font-icon font-icon-learn"></i> <?php echo $_SESSION['campuse'] ?>
                                </p>
                                <p class="line-with-icon">
                                    <i class="font-icon font-icon-learn"></i>Aula Virtual App
                                </p>
                                <p class="line-with-icon">
                                    <i class="font-icon font-icon-users-two"></i><?php echo $_SESSION['email'] ?>
                                </p>
                                <p class="line-with-icon">
                                    <i class="font-icon font-icon-calend"></i> Registrado el <?php echo date('Y-m-d', strtotime($_SESSION['created'])) ?>
                                </p>
                            </div>
                        </section>
                        <!--.profile-side-->
                    </div>
                    <div class="col-xl-9 col-lg-8">
                        <section class="tabs-section">
                            <div class="tabs-section-nav tabs-section-nav-left">
                                <ul class="nav" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#tabs-2-tab-4" role="tab" data-toggle="tab">
                                            <span class="nav-link-in" id="settings">Settings</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!--.tabs-section-nav-->
                            <div class="tab-content no-styled profile-tabs">
                                <!--.tab-pane-->
                                <div role="tabpanel" class="tab-pane" id="tabs-2-tab-4">
                                    <section class="box-typical profile-settings">
                                    	<header class="box-typical-header-sm">Información Personal</header>
                                    	<form method="post" id="user_perfil">
                                            <section class="box-typical-section">
                                            	<input type="hidden" id="id" name="id" />
                                            	<?php
                                            	if($_SESSION['is_google'] === 1){
                                            	?>
                                            	<div class="form-group row">
                                            		<div class="col-xl-2">
                                                    	<label for="identification_type_id" class="form-label">Tipo Identificacion <b>*</b></label>
                                                    </div>
                                                    <div class="col-xl-7">
                                                        <select id="identification_type_id" class="form-control" name="identification_type_id">
                            							</select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-xl-2">
                                                        <label class="form-label" for="identification">Identificacion <b>*</b></label>
                                                    </div>
                                                    <div class="col-xl-7">
                                                        <input class="form-control" id="identification" name="identification" type="text" placeholder="Ingrese su numero de identificacion">
                                                    </div>
                                                </div>
                                                <?php
                                                // Calcular la fecha maxima permitida (10 años atras desde la fecha actual)
                                                $maxDate = date('Y-m-d', strtotime('-10 years -1 day'));
                                                ?>
                                                <div class="form-group row">
                                                    <div class="col-xl-2">
                                                        <label class="form-label" for="birthdate">Fecha Nacimiento <b>*</b></label>
                                                    </div>
                                                    <div class="col-xl-7">
                                                        <input class="form-control" id="birthdate" name="birthdate" type="date" max="<?php echo $maxDate; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                            		<div class="col-xl-2">
                                                    	<label for="sex" class="form-label">Sexo <b>*</b></label>
                                                    </div>
                                                    <div class="col-xl-7">
                                                        <select id="sex" class="form-control" name="sex">
                                                        	<option value=""></option>
                                                        	<option value="M">Masculino</option>
                                                        	<option value="F">Femenino</option>
                            							</select>
                                                    </div>
                                                </div>
                                            	<?php
                                            	}
                                            	?>
                                                <div class="form-group row">
                                                    <div class="col-xl-2">
                                                        <label class="form-label" for="name">Nombre <b>*</b></label>
                                                    </div>
                                                    <div class="col-xl-7">
                                                        <input class="form-control" id="name" name="name" type="text" placeholder="Ingrese su nombre">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-xl-2">
                                                        <label class="form-label" for="lastname">Apellido <b>*</b></label>
                                                    </div>
                                                    <div class="col-xl-7">
                                                        <input class="form-control" id="lastname" name="lastname" type="text" placeholder="Ingrese su apellido">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-xl-2">
                                                        <label class="form-label" for="email">Correo Electronico <b>*</b></label>
                                                    </div>
                                                    <div class="col-xl-7">
                                                        <input class="form-control" id="email" name="email" type="email" placeholder="Ingrese su correo electronico">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-xl-2">
                                                        <label class="form-label" for="phone">Celular <b>*</b></label>
                                                    </div>
                                                    <div class="col-xl-7">
                                                        <input class="form-control" id="phone" name="phone" type="text" placeholder="Ingrese su celular">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-xl-2">
                                                        <label class="form-label" for="phone2">Celular 2</label>
                                                    </div>
                                                    <div class="col-xl-7">
                                                        <input class="form-control" id="phone2" name="phone2" type="text" placeholder="Ingrese su celular opcional">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-xl-9">
                                                        <label class="form-label semibold" for="repeatPass"><i class="font-icon font-icon-pin-2"></i>Nueva clave</label>
        												<input type="text" name="repeatPass" id="repeatPass" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-xl-9">
                                                        <label class="form-label semibold" for="password_hash"><i class="font-icon font-icon-pin-2"></i>Confirmar clave</label>
        												<input type="text" name="password_hash" id="password_hash" class="form-control" />
                                                    </div>
                                                </div>
                                            </section>
                                            <section class="box-typical-section profile-settings-btns">
                                                <button type="submit" id="#" name="action" value="add" class="btn btn-rounded btn-inline btn-primary">Actualizar</button>
                                            </section>
                                       	</form>
                                    </section>
                                </div>
                                <!--.tab-pane-->
                            </div>
                            <!--.tab-content-->
                        </section>
                        <!--.tabs-section-->
                    </div>
                </div>
           	</div>
		</div>
	</div>
	<!-- Contenido  -->

	<?php
    require_once ("../html/js.php");
    ?>

<script src="perfil.js" type="text/javascript"></script>

</body>
</html>
<?php
} else {
    header("Location:" . Database::route() . "views/404/");
    exit;
}
?>