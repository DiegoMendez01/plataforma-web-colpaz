<div id="modalGestionCampuse" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labellebdy="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="max-width: 800px; width: 800px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="model-close" data-dismiss="modal" aria-label="Close">
					<i class="font-icon-close-2"></i>
				</button>
				<h4 class="modal-title" id="mdltitulo"></h4>
			</div>
			<form method="post" id="campuse_form">
    			<div class="modal-body">
    				<input type="hidden" id="idr" name="idr" />
    				<div class="form-group row">
                        <label for="name" class="col-sm-2 form-control-label">Nombre <b>*</b></label>
                        <div class="col-sm-10">
                            <p class="form-control-static"><input type="text" class="form-control" id="name" name="name" placeholder="Ingrese el nombre de la sede"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="description" class="col-sm-2 form-control-label">Descripcion <b>*</b></label>
                        <div class="col-sm-10">
                            <p class="form-control-static"><textarea id="description" class="form-control" name="description" rows="4"></textarea></p>
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