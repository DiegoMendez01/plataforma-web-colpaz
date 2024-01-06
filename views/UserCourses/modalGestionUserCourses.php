<div id="modalGestionUserCourses" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="model-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltitulo"></h4>
            </div>
            <form method="post" id="UserCourses_form">
                <div class="modal-body">
                    <input type="hidden" id="id" name="id" />
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 form-control-label">Nombre <b>*</b></label>
                        <div class="col-sm-10">
                            <p class="form-control-static"><input type="text" class="form-control" id="name" name="name" placeholder="Ingrese el nombre del grado"></p>
                        </div>
                    </div>
                    <div class="form-group row">
    					<label for="user" class="col-sm-2 form-control-label">Usuario <b>*</b></label>
    					<div class="col-sm-10">
       						 <p class="form-control-static"><input type="text" class="form-control" id="user" name="user" placeholder="Ingrese el nombre de usuario"></p>
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