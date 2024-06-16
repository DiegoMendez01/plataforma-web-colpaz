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
        return false;
    }
    
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
							$('#user_register')[0].reset();
							$.post("../../controllers/EmailController.php?op=confirmed_email", { id : data.id}, function(data) {
        					
        					});
							swal({
						    	title: "ColPaz Quipama",
						    	text: data.msg,
						    	type: "success",
						    	showCancelButton: true,
						    	confirmButtonClass: "btn-success",
						    	confirmButtonText: "Reenviar",
						    	cancelButtonText: "Salir",
						    	closeOnConfirm: false
							},
							function(isConfirm)
							{
								if(isConfirm){
									$.post("../../controllers/EmailController.php?op=confirmed_email", { id : data.id}, function(data) {
        								window.open('http://localhost/plataforma-web-colpaz/views/site/submitted-email.php?msg=1');
        							});
								}
							});
						}else{
							if(data.error){
								swal("Advertencia", data.msg, "error");
							}else{
								var errorMessage = "Ya existen datos registrados. Los campos afectados son:\n";
						        data.msg.forEach(function (duplicateInfo) {
						            errorMessage += duplicateInfo.type + ': ' + duplicateInfo.value + '\n';
						        });
						        swal("Advertencia", errorMessage, "error");
					        }
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
						$.post("../../controllers/EmailController.php?op=confirmed_email", { id : data.id}, function(data) {
    					
    					});
						swal({
					    	title: "ColPaz Quipama",
					    	text: data.msg,
					    	type: "success",
					    	showCancelButton: true,
					    	confirmButtonClass: "btn-success",
					    	confirmButtonText: "Reenviar",
					    	cancelButtonText: "Salir",
					    	closeOnConfirm: false
						},
						function(isConfirm)
						{
							if(isConfirm){
								$.post("../../controllers/EmailController.php?op=confirmed_email", { id : data.id}, function(data) {
    								window.open('http://localhost/plataforma-web-colpaz/views/site/submitted-email.php?msg=1');
    							});
							}
						});
					}else{
				        if(data.error){
							swal("Advertencia", data.msg, "error");
						}else{
							var errorMessage = "Ya existen datos registrados. Los campos afectados son:\n";
					        data.msg.forEach(function (duplicateInfo) {
					            errorMessage += duplicateInfo.type + ': ' + duplicateInfo.value + '\n';
					        });
					        swal("Advertencia", errorMessage, "error");
				        }
		        	}
				}
			});
		}
    } else {
        swal("Error!", "Las claves no coinciden", "error");
    }
});

init();