function init()
{
	$('#content_form').on("submit", function(e){
		insertOrUpdate(e);
	});
}

function insertOrUpdate(e)
{
	e.preventDefault();
	var formData = new FormData($('#content_form')[0]);
	
	var camposVacios = false;
	
    formData.forEach(function(value, key) {
	    // Excluir id del chequeo de campos vacios
	    if (key !== 'id' && key !== 'video') {
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
			url: "../../controllers/ContentController.php?op=insertOrUpdate",
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
	
	$.post("../../controllers/ContentController.php?op=listContentById", { id : id}, function(data) {
    	data = JSON.parse(data);
    	$('#id').val(data.id);
    	$('#title').val(data.title);
    	$('#description').val(data.description);
    	$('#type').val(data.type).trigger('change');
    	$('#video').val(data.video);
    	$('#teacher_course_id').val(data.teacher_course_id);
    });
	
	$('#modalGestionContenido').modal('show');
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
			$.post("../../controllers/ContentController.php?op=deleteContentById", { id : id}, function(data) {
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
			$.post("../../controllers/ContentController.php?op=statusBloqContentById", { id : id}, function(data) {
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
			$.post("../../controllers/ContentController.php?op=statusDesbloqContentById", { id : id}, function(data) {
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
	$('#content_form')[0].reset();
	$('#modalGestionContenido').modal('show');
});

init();