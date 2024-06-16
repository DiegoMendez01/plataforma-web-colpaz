<div id="modalAsignCampuse" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labellebdy="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="model-close" data-dismiss="modal" aria-label="Close">
					<i class="font-icon-close-2"></i>
				</button>
				<h4 class="modal-title" id="xmdltitulo"></h4>
			</div>
			<form method="post" id="campuse_form">
    			<div class="modal-body">
    				<input type="hidden" id="xid" name="xid">
    				<div class="form-group row">
        				<label for="idr" class="col-sm-2 form-control-label">Sede <b>*</b></label>
                        <div class="col-sm-10">
                            <select id="idr" class="form-control" name="idr">
								<option value="0" selected>Seleccionar</option>
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