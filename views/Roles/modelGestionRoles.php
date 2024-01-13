<div id="modalRoles" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labellebdy="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="model-close" data-dismiss="modal" aria-label="Close">
					<i class="font-icon-close-2"></i>
				</button>
				<h4 class="modal-title" id="mdltitulo"></h4>
			</div>
			<form method="post" id="roles_form">
    			<div class="modal-body">
    				<input type="hidden" id="user_id" name="user_id">
    				<div class="form-group">
    					<label class="form-label" for="role_id">Roles</label>
    					<select class="select2" id="role_id" name="role_id" data-placeholder="Seleccionar" required>
                            <option value="">Seleccione</option>
    						<option value="2">Administrador</option>
    						<option value="3">Docente</option>
    						<option value="4">Estudiante</option>
    						<option value="5">Usuario Provisional</option>
    					</select>
    				</div>
    			</div>
    			<div class="modal-footer">
    				<button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cerrar</button>
    				<button type="submit" name="action" id="#" value="add" class="btn btn-rounded btn-primary">Asignar</button>
    			</div>
			</form>
		</div>
	</div>
</div>