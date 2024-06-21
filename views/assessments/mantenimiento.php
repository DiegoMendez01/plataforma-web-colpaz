<div id="modalAssessment" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labellebdy="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="max-width: 800px; width: 800px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="model-close" data-dismiss="modal" aria-label="Close">
					<i class="font-icon-close-2"></i>
				</button>
				<h4 class="modal-title" id="mdltitulo"></h4>
			</div>
			<form method="post" id="assessment_form">
    			<div class="modal-body">
    				<input type="hidden" id="id" name="id" />
    				<input type="hidden" id="content_id" name="content_id" value="<?= $contentId ?>" />
    				<div class="form-group row">
                        <label for="title" class="col-sm-2 form-control-label">Titulo <b>*</b></label>
                        <div class="col-sm-10">
                            <p class="form-control-static"><input type="text" class="form-control" id="title" name="title" placeholder="Ingrese el nombre del curso"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="comment" class="col-sm-2 form-control-label">Comentario <b>*</b></label>
                        <div class="col-sm-10">
                            <textarea id="description" class="form-control" name="comment" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="date_limit" class="col-sm-2 form-control-label">Fecha Limite <b>*</b></label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="date_limit" name="date_limit" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="percentage" class="col-sm-2 form-control-label">Valor Evaluacion <b>*</b></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="percentage" name="percentage" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="file" class="col-sm-2 form-control-label">Archivo <b>*</b></label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="file" name="file" />
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