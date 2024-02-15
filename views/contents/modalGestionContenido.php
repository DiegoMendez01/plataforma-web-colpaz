<div id="modalGestionContenido" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labellebdy="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="max-width: 800px; width: 800px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="model-close" data-dismiss="modal" aria-label="Close">
					<i class="font-icon-close-2"></i>
				</button>
				<h4 class="modal-title" id="mdltitulo"></h4>
			</div>
			<form method="post" id="content_form">
    			<div class="modal-body">
    				<input type="hidden" id="id" name="id" />
    				<input type="hidden" id="teacher_course_id" name="teacher_course_id" value="<?= $courseId ?>" />
    				<div class="form-group row">
                        <label for="title" class="col-sm-2 form-control-label">Titulo <b>*</b></label>
                        <div class="col-sm-10">
                            <p class="form-control-static"><input type="text" class="form-control" id="title" name="title" placeholder="Ingrese el nombre del curso"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="description" class="col-sm-2 form-control-label">Descripcion <b>*</b></label>
                        <div class="col-sm-10">
                            <textarea id="description" class="form-control" name="description" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="type" class="col-sm-2 form-control-label">Tipo <b>*</b></label>
                        <div class="col-sm-10">
        					<select class="select2" id="type" name="type" data-placeholder="Seleccionar" required>
                                <option value="">Seleccione</option>
        						<option value="PDF">PDF</option>
        						<option value="TEXT">TEXT</option>
        						<option value="CSV">CSV</option>
        						<option value="WORD">WORD</option>
        						<option value="WORD">OTRO</option>
        					</select>
    					</div>
    				</div>
                    <div class="form-group row">
                        <label for="type" class="col-sm-2 form-control-label">Carga Archivo <b>*</b></label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="file" name="file" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="video" class="col-sm-2 form-control-label">Link del video YT</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="video" name="video" />
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