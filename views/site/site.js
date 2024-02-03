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
	swal({
    	title: "ColPaz Quipama",
    	text: "El correo ha sido enviado a tu bandeja de entrada. Por favor verifica.",
    	type: "success",
    	showCancelButton: true,
    	cancelButtonText: "Salir",
    	closeOnConfirm: false
	},
	function(isConfirm)
	{
		if(isConfirm){
			$.post("../../controllers/EmailController.php?op=confirmed_email", { email : email}, function(data) {
				var newURL = window.location.href.split('?')[0];
	            window.history.replaceState({}, document.title, newURL);
	            // Recargar la pagina
	            location.reload();
			});
		}
	});
});