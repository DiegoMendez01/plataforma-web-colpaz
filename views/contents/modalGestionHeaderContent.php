<div id="modalGestionHeaderContent" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labellebdy="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="max-width: 800px; width: 800px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="model-close" data-dismiss="modal" aria-label="Close">
					<i class="font-icon-close-2"></i>
				</button>
				<h4 class="modal-title" id="mdltitulo"></h4>
			</div>
			<form method="post" id="header_content_form">
    			<div class="modal-body">
    				<input type="hidden" id="id" name="id" />
    				<input type="hidden" id="teacher_course_id" name="teacher_course_id" value="<?= $courseId ?>" />
    				<div class="form-group row">
                        <label for="supplementary_file" class="col-sm-2 form-control-label">Plan de Estudios <b>*</b></label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="supplementary_file" name="supplementary_file" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="curriculum_file" class="col-sm-2 form-control-label">Archivo complementario <b>*</b></label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="curriculum_file" name="curriculum_file" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="header_video" class="col-sm-2 form-control-label">Link del video YT</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="header_video" name="header_video" />
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