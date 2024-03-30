function init()
{
	
}

$(document).ready(function(){
	let id = $('#user_idx').val();
	
	$.post("../../controllers/IdentificationTypeController.php?op=combo", function(data){
		$('#identification_type_id').html(data)
	})
	
	$.post("../../controllers/UserController.php?op=listUserById", { id : id}, function(data) {
    	data = JSON.parse(data);
    	$('#id').val(data.id);
    	$('#name').val(data.name);
    	$('#lastname').val(data.lastname);
    	$('#email').val(data.email);
    	if(data.phone == ''){
			$('#phone').val('');
    		$('#phone2').val('');
		}else{
	    	$('#phone').val(data.phone);
	    	$('#phone2').val(data.phone2);
    	}
    });
});

$('#user_perfil').on("submit", function(e){
	e.preventDefault();
	var formData = new FormData($('#user_perfil')[0]);

    // Validar si alguno de los campos esta vacio
    var camposVacios = false;

    formData.forEach(function(value, key) {
		// Excluir phone2 de campos vacios
	    if (key !== "phone2" && key !== "password_hash" && key !== "repeatPass") {
	        if (value === "") {
	            camposVacios = true;
	            return false; // Sale del bucle forEach si encuentra un campo vacio
	        }
        }
    });
    
	if (camposVacios) {
        swal("Error!", "Campos vacios", "error");
    } else {
        var repeatPass    = formData.get('repeatPass');
        var password_hash = formData.get('password_hash');
        if (repeatPass === password_hash) {
			formData.delete('repeatPass');
            var phone = formData.get('phone');
        	var phone2 = formData.get('phone2');
        	if(phone2 !== ""){
				if(phone2 !== phone){
	            	$.ajax({
						url: "../../controllers/UserController.php?op=updateUserPerfilById",
						type: "POST",
						data: formData,
						contentType: false,
						processData: false,
						success: function(data){
							if(data !== ''){
								jsonData = JSON.parse(data);
						        var errorMessage = "Ya existen datos registrados. Los campos afectados son:\n";
						        jsonData.message.forEach(function (duplicateInfo) {
						            errorMessage += duplicateInfo.type + ': ' + duplicateInfo.value + '\n';
						        });
						        swal("Error", errorMessage, "error");
							}else{
								location.reload();
				        	}
						}
					});
				}else{
					swal("Error!", "Los celulares deben ser diferentes", "error");
				}
			}else{
				$.ajax({
					url: "../../controllers/UserController.php?op=updateUserPerfilById",
					type: "POST",
					data: formData,
					contentType: false,
					processData: false,
					success: function(data){
						if(data !== ''){
							jsonData = JSON.parse(data);
					        var errorMessage = "Ya existen datos registrados. Los campos afectados son:\n";
					        jsonData.message.forEach(function (duplicateInfo) {
					            errorMessage += duplicateInfo.type + ': ' + duplicateInfo.value + '\n';
					        });
					        swal("Error", errorMessage, "error");
						}else{
							location.reload();
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