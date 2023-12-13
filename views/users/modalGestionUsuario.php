<div id="modalGestionUsuario" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labellebdy="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="max-width: 1200px; width: 1200px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="model-close" data-dismiss="modal" aria-label="Close">
					<i class="font-icon-close-2"></i>
				</button>
				<h4 class="modal-title" id="mdltitulo"></h4>
			</div>
			<form method="post" id="user_form">
    			<div class="modal-body">
    				<input type="hidden" id="id" name="id" />
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
    			</div>
    			<div class="modal-footer">
    				<button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cerrar</button>
    				<button type="submit" name="action" id="#" value="add" class="btn btn-rounded btn-primary">Guardar</button>
    			</div>
			</form>
		</div>
	</div>
</div>