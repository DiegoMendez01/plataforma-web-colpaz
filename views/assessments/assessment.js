function init()
{
    $('#assessment_form').on("submit", function(e){
		insertOrUpdate(e);
	});

	setMinDate();
}

function setMinDate() {
    var dateInput = document.getElementById('date_limit');
    var today 	  = new Date();
    var day       = String(today.getDate()).padStart(2, '0');
    var month     = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
    var year      = today.getFullYear();
    var todayDate = year + '-' + month + '-' + day;
    dateInput.setAttribute('min', todayDate);
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
        url: "../../controllers/AssessmentController.php?op=createOrUpdate",
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

function editAssessment(id){
	$('#mdltitulo').html('Editar Registro');
	
	$.post("../../controllers/AssessmentController.php?op=show", { id : id}, function(data) {
    	data = JSON.parse(data);
    	$('#id').val(data.id);
    	$('#title').val(data.title);
        $('#date_limit').val(data.date_limit);
        $('#percentage').val(data.percentage);
    	$('#comment').val(data.comment);
    });
	
	$('#modalAssessment').modal('show');
}

function deleteAssessment(id){
	swal({
    	title: "ColPaz Quipama",
    	text: "¿Esta seguro de eliminar la actividad?",
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
			$.post("../../controllers/AssessmentController.php?op=delete", { id : id}, function(data) {
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

$(document).on("click", "#btnnuevo", function(){
	document.querySelector('#id').value = '';
	$('#mdltitulo').html('Nuevo Registro');
	$('#assessment_form')[0].reset();
	$('#modalAssessment').modal('show');
});

init()