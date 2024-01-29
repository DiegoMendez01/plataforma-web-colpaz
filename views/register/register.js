function init()
{
	
}

$(document).ready(function(){
	$('#user_register')[0].reset();
});

$('#user_register').on("submit", function(e){
	e.preventDefault();
	var formData = new FormData($('#user_register')[0]);
	
	var camposVacios = false;
	
    formData.forEach(function(value, key) {
	    // Excluir email, phone y phone2 del chequeo de campos vacios
	    if (key !== "phone2") {
	        if (value === "") {
	            camposVacios = true;
	            return false;  // Para salir del bucle si se encuentra un campo vacio
	        }
	    }
	});
    
    if (camposVacios) {
        swal("Error!", "Campos vacíos", "error");
    } else {
        var repeatPass = formData.get('repeatPass');
        var password = formData.get('password_hash');
        if (repeatPass === password) {
			formData.delete('repeatPass');
			var phone = formData.get('phone');
        	var phone2 = formData.get('phone2');
        	if(phone !== ""  && phone2 !== ""){
				if(phone2 !== phone){
	            	$.ajax({
						url: "../../controllers/userController.php?op=insertOrUpdate",
						type: "POST",
						data: formData,
						contentType: false,
						processData: false,
						success: function(data){
							data = JSON.parse(data);
							if(data.status){
								$.post("../../controllers/EmailController.php?op=confirmed_email", { id : data.message}, function(data) {
        						});
								$('#user_register')[0].reset();
					        	swal("Correctamente!", "Ha sido registrado correctamente, por favor verifica tu correo electronico", "success");
							}else{
								var errorMessage = "Ya existen datos registrados. Los campos afectados son:\n";
						        data.message.forEach(function (duplicateInfo) {
						            errorMessage += duplicateInfo.type + ': ' + duplicateInfo.value + '\n';
						        });
						        swal("Error", errorMessage, "error");
				        	}
						}
					});
				}else{
					swal("Error!", "Las celulares deben ser diferentes", "error");
				}
			}else{
				$.ajax({
					url: "../../controllers/userController.php?op=insertOrUpdate",
					type: "POST",
					data: formData,
					contentType: false,
					processData: false,
					success: function(data){
						data = JSON.parse(data);
						if(data.status){
							$('#user_register')[0].reset();
							$.post("../../controllers/EmailController.php?op=confirmed_email", { id : data.message}, function(data) {
        					});
				        	swal("Correctamente!", "Ha sido registrado correctamente, por favor verifica tu correo electronico", "success");
						}else{
					        var errorMessage = "Ya existen datos registrados. Los campos afectados son:\n";
					        data.message.forEach(function (duplicateInfo) {
					            errorMessage += duplicateInfo.type + ': ' + duplicateInfo.value + '\n';
					        });
					        swal("Error", errorMessage, "error");
			        	}
					}
				});
			}
        } else {
            swal("Error!", "Las claves no coinciden", "error");
        }
    }
});

init();