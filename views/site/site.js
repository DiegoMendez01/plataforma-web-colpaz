$('#submitted_email').on("submit", function(e){
	e.preventDefault();
	var formData = new FormData($('#submitted_email')[0]);
	
	var camposVacios = false;
	
    formData.forEach(function(value, key) {
	    // Excluir email, phone y phone2 del chequeo de campos vacios
        if (value === "") {
            camposVacios = true;
            return false;  // Para salir del bucle si se encuentra un campo vacio
        }
	});
    
    if (camposVacios) {
        swal("Error!", "Campos vacios", "error");
        return false;
    }
    
	var email = formData.get('email');
	$('#submitted_email')[0].reset();
	swal("Atencion", "El correo ha sido enviado a tu bandeja de entrada. Por favor verifica.", "success");
	$.post("../../controllers/EmailController.php?op=confirmed_email", { email : email}, function(data) {
	
	});
});