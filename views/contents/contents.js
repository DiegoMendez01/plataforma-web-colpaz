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

$(document).on("click", "#btnnuevo", function(){
	document.querySelector('#id').value = '';
	$('#mdltitulo').html('Nuevo Registro');
	$('#content_form')[0].reset();
	$('#modalGestionContenido').modal('show');
});

init();