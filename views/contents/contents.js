function init()
{
	$('#content_form').on("submit", function(e){
		insertOrUpdate(e);
	});
	
	$('#header_content_form').on("submit", function(e){
		insertOrUpdateHeader(e);
	});
}

function insertOrUpdateHeader(e)
{
	e.preventDefault();
	var formData = new FormData($('#header_content_form')[0]);
	
	var camposVacios = false;
	
    formData.forEach(function(value, key) {
	    // Excluir id del chequeo de campos vacios
	    if (key !== 'idHeader' && key !== 'header_video') {
	        if (value === "") {
	            camposVacios = true;
	            return false;  // Para salir del bucle si se encuentra un campo vacio
	        }
	    }
	});
    
    if (camposVacios) {
        swal("Error!", "Campos vacios", "error");
    } else {
    	$.ajax({
			url: "../../controllers/HeaderContentController.php?op=createOrUpdate",
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			success: function(data){
				data = JSON.parse(data);
				if(data.status){
					swal({
				    	title: "ColPaz Quipama",
				    	text: data.msg,
				    	type: "success",
				    	confirmButtonClass: "btn-success",
				    	confirmButtonText: "Aceptar",
				    	closeOnConfirm: false
					},
					function(isConfirm)
					{
						if(isConfirm){
							$('#header_content_form')[0].reset();
							$('#modalGestionHeaderContent').modal('hide');
							location.reload();
						}
					});
				}else{
					swal("Atencion", data.msg, "error");
				}
			}
		});
    }
}

function insertOrUpdate(e)
{
	e.preventDefault();
	var formData = new FormData($('#content_form')[0]);
	
	var camposVacios = false;
	
    formData.forEach(function(value, key) {
	    if (key !== 'id' && key !== 'video') {
	        if (key === 'file') {
				if ($('#file')[0].files.length === 0) {
					camposVacios = true;
					return false;
				}
			} else if (value === "") {
				camposVacios = true;
				return false;
			}
	    }
	});
	
    if (camposVacios) {
        swal("Advertencia", "Todos los campos son necesarios", "error");
    } else {
    	$.ajax({
			url: "../../controllers/ContentController.php?op=createOrUpdate",
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			success: function(data){
				data = JSON.parse(data);
				if(data.status){
					swal({
				    	title: "ColPaz Quipama",
				    	text: data.msg,
				    	type: "success",
				    	confirmButtonClass: "btn-success",
				    	confirmButtonText: "Aceptar",
				    	closeOnConfirm: false
					},
					function(isConfirm)
					{
						if(isConfirm){
							$('#content_form')[0].reset();
							$('#modalGestionContenido').modal('hide');
							location.reload();
						}
					});
				}else{
					swal("Atencion", data.msg, "error");
				}
			}
		});
    }
}

function editar(id){
	$('#mdltitulo').html('Editar Registro');
	
	$.post("../../controllers/ContentController.php?op=show", { id : id}, function(data) {
    	data = JSON.parse(data);
    	$('#id').val(data.id);
    	$('#title').val(data.title);
    	$('#description').val(data.description);
    	$('#video').val(data.video);
    });
	
	$('#modalGestionContenido').modal('show');
}

function editarHeader(id){
	$('#mdltitulo').html('Editar Registro');
	
	$.post("../../controllers/HeaderContentController.php?op=show", { idHeader : id}, function(data) {
    	data = JSON.parse(data);
    	$('#idHeader').val(data.id);
    	$('#header_content_id').val(data.header_content_id);
    	$('#header_video').val(data.header_video);
    });
	
	$('#modalGestionHeaderContent').modal('show');
}

function eliminar(id){
	swal({
    	title: "ColPaz Quipama",
    	text: "¿Esta seguro de eliminar el contenido?",
    	type: "error",
    	showCancelButton: true,
    	confirmButtonClass: "btn-danger",
    	confirmButtonText: "Si",
    	cancelButtonText: "No",
    	closeOnConfirm: false
	},
	function(isConfirm)
	{
		if(isConfirm){
			$.post("../../controllers/ContentController.php?op=delete", { id : id}, function(data) {
        		swal({
			    	title: "ColPaz Quipama",
			    	text: "Registro eliminado",
			    	type: "success",
			    	confirmButtonClass: "btn-success",
			    	confirmButtonText: "Aceptar",
			    	closeOnConfirm: false
				},
				function(isConfirm)
				{
					if(isConfirm){
						location.reload();
					}
				});
        	});
		}
	});
}

function bloquear(id){
	swal({
    	title: "ColPaz Quipama",
    	text: "¿Esta seguro de bloquear el contenido?",
    	type: "error",
    	showCancelButton: true,
    	confirmButtonClass: "btn-danger",
    	confirmButtonText: "Si",
    	cancelButtonText: "No",
    	closeOnConfirm: false
	},
	function(isConfirm)
	{
		if(isConfirm){
			$.post("../../controllers/ContentController.php?op=disabled", { id : id}, function(data) {
        		swal({
			    	title: "ColPaz Quipama",
			    	text: "Contenido bloqueado",
			    	type: "success",
			    	confirmButtonClass: "btn-success",
			    	confirmButtonText: "Aceptar",
			    	closeOnConfirm: false
				},
				function(isConfirm)
				{
					if(isConfirm){
						location.reload();
					}
				});
        	});
		}
	});
}

function desbloquear(id){
	swal({
    	title: "ColPaz Quipama",
    	text: "¿Esta seguro de desbloquear el contenido?",
    	type: "success",
    	showCancelButton: true,
    	confirmButtonClass: "btn-success",
    	confirmButtonText: "Si",
    	cancelButtonText: "No",
    	closeOnConfirm: false
	},
	function(isConfirm)
	{
		if(isConfirm){
			$.post("../../controllers/ContentController.php?op=enabled", { id : id}, function(data) {
        		swal({
			    	title: "ColPaz Quipama",
			    	text: "Contenido desbloqueado",
			    	type: "success",
			    	confirmButtonClass: "btn-success",
			    	confirmButtonText: "Aceptar",
			    	closeOnConfirm: false
				},
				function(isConfirm)
				{
					if(isConfirm){
						location.reload();
					}
				});
        	});
		}
	});
}

$(document).on("click", "#btnnuevo", function(){
	document.querySelector('#id').value = '';
	$('#mdltitulo').html('Nuevo Registro');
	$('#header_content_form')[0].reset();
	$('#modalGestionHeaderContent').modal('show');
});

$(document).on("click", "#btnnuevocontenido", function(){
	document.querySelector('#idHeader').value = '';
	$('#mdltitulo').html('Nuevo Registro');
	$('#content_form')[0].reset();
	$('#modalGestionContenido').modal('show');
});

init();