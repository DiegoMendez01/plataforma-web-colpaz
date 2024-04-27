<div id="modalAsignRole" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labellebdy="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="model-close" data-dismiss="modal" aria-label="Close">
					<i class="font-icon-close-2"></i>
				</button>
				<h4 class="modal-title" id="mdltitulo"></h4>
			</div>
			<form method="post" id="userRol_form">
    			<div class="modal-body">
    				<input type="hidden" id="user_id" name="user_id">
    				<div class="form-group row">
        				<label for="role_id" class="col-sm-2 form-control-label">Rol <b>*</b></label>
                        <div class="col-sm-10">
                            <select id="role_id" class="form-control" name="role_id">
    						</select>
                        </div>
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