function init()
{
    $('#assessment_form').on("submit", function(e){
		insertOrUpdate(e);
	});
}

function insertOrUpdate(e)
{
	e.preventDefault();
	var formData = new FormData($('#assessment_form')[0]);
	
	var camposVacios = false;
	
    formData.forEach(function(value, key) {
	    // Excluir id del chequeo de campos vacios
	    if (key !== 'id') {
	        if (value === "") {
	            camposVacios = true;
	            return false;  // Para salir del bucle si se encuentra un campo vacio
	        }
	    }
	});
    
    if (camposVacios) {
        swal("Error!", "Campos vacios", "error");
        return false;
    }
    $.ajax({
        url: "../../controllers/AssessmentController.php?op=insertOrUpdate",
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
                        $('#assessment_form')[0].reset();
                        $('#modalAssessment').modal('hide');
                        location.reload();
                    }
                });
            }else{
                swal("Atencion", data.msg, "error");
            }
        }
    });
}

$(document).on("click", "#btnnuevo", function(){
	document.querySelector('#id').value = '';
	$('#mdltitulo').html('Nuevo Registro');
	$('#assessment_form')[0].reset();
	$('#modalAssessment').modal('show');
});

init()