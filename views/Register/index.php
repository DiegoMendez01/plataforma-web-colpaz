<!DOCTYPE html>
<html>

<head lang="es">
    <?php 
	require_once("../MainHead/head.php");
	?>
	<title>Aula Virtual::Registro</title>
</head>

<body>
    <div class="page-content" style="margin-top: 0; padding-top: 20px;">
        <div class="container-fluid">
            <header class="section-header">
                <div class="tbl">
                    <div class="tbl-row">
                        <div class="tbl-cell">
                            <ol class="breadcrumb breadcrumb-simple">
                                <li><a href="../Site/">Login</a></li>
                                <li class="active">Register</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </header>
            <div class="box-typical box-typical-padding">
                <p>
                    Módulo que permite al usuario registrar su cuenta personal para el ingreso al Aula Virtual de la Institución Educativa.
                </p>
                <div class="col-md-12 text-center">
                    <img class="hidden-md-down" src="../../public/img/LogoCOLPAZ.png" alt="Logo" style="height: 20vh;">
                </div>
                <h2 class="m-t-lg with-border">Formulario de Registro</h2>

                <form method="post" id="user_register">
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 form-control-label">Nombres <b>*</b></label>
                        <div class="col-sm-10">
                            <p class="form-control-static"><input type="text" class="form-control" id="name" name="name" placeholder="Ingrese sus nombres"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lastname" class="col-sm-2 form-control-label">Apellidos <b>*</b></label>
                        <div class="col-sm-10">
                            <p class="form-control-static"><input type="text" class="form-control" id="lastname" name="lastname" placeholder="Ingrese sus apellidos"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="username" class="col-sm-2 form-control-label">Username <b>*</b></label>
                        <div class="col-sm-10">
                            <p class="form-control-static"><input type="text" class="form-control" id="username" name="username" placeholder="Ingrese su username"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="identification_type_id" class="col-sm-2 form-control-label">Tipo de Identificación <b>*</b></label>
                        <div class="col-sm-10">
                            <select id="identification_type_id" class="form-control" name="identification_type_id">
                                <option value="">Seleccione</option>
								<option value="1">Cédula de Ciudadanía</option>
								<option value="2">Tarjeta de Identidad</option>
								<option value="3">Registro Civil</option>
                                <option value="4">Cédula de extranjería</option>
							</select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="identification" class="col-sm-2 form-control-label">Identificación <b>*</b></label>
                        <div class="col-sm-10">
                            <p class="form-control-static"><input type="text" class="form-control" id="identification" name="identification" placeholder="Ingrese su número de identificación"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="repeatPass" class="col-sm-2 form-control-label">Clave <b>*</b></label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="repeatPass" name="repeatPass" placeholder="Ingrese su clave de seguridad">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password_hash" class="col-sm-2 form-control-label">Repetir Clave <b>*</b></label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password_hash" name="password_hash" placeholder="Ingrese su clave de seguridad">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 form-control-label">Correo eléctronico <b>*</b></label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese su correo eléctronico">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone" class="col-sm-2 form-control-label">Celular <b>*</b></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Ingrese su celular de contacto">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone2" class="col-sm-2 form-control-label">Celular 2</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="phone2" name="phone2" placeholder="Ingrese otro celular de contacto">
                        </div>
                    </div>
                    <?php
                    // Calcular la fecha maxima permitida (10 años atras desde la fecha actual)
                    $maxDate = date('Y-m-d', strtotime('-10 years -1 day'));
                    ?>
                    <div class="form-group row">
                        <label for="birthdate" class="col-sm-2 form-control-label">Fecha de nacimiento <b>*</b></label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="birthdate" name="birthdate" max="<?php echo $maxDate; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="sex" class="col-sm-2 form-control-label">Sexo <b>*</b></label>
                        <div class="col-sm-10">
                            <select id="sex" class="form-control" name="sex">
                                <option value="">Seleccione</option>
								<option value="M">Masculino</option>
								<option value="F">Femenino</option>
							</select>
                        </div>
                    </div>
                    <div class="form-group" style="display: flex; justify-content: center; align-items: center;">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--.page-center-->
	<?php
	require_once("../MainJs/js.php");
	?>
	<script src="register.js" type="text/javascript"></script>
</body>

</html>