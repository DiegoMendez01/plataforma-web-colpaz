<div id="modalGestionStudentTeacher" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="model-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltitulo"></h4>
            </div>
            <form method="post" id="studentteacher_form">
                <div class="modal-body">
                    <input type="hidden" id="id" name="id" />
                    <div class="form-group row">
                        <label for="teacher_course_id" class="col-sm-2 form-control-label">Profesor <b>*</b></label>
                        <div class="col-sm-10">
                            <select id="teacher_course_id" class="form-control" name="teacher_course_id">
							</select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="period_id" class="col-sm-2 form-control-label">Periodo<b>*</b></label>
                        <div class="col-sm-10">
                            <select id="period_id" class="form-control" name="period_id">
							</select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="user_id" class="col-sm-2 form-control-label">Estudiante <b>*</b></label>
                        <div class="col-sm-10">
                            <select id="user_id" class="form-control" name="user_id">
							</select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" name="action" id="btnGuardar" class="btn btn-rounded btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>