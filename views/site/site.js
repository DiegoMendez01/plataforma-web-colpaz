$(document).ready(function(){
	var btnEnviar = $('#btnsubmit');
    // Deshabilitar el boton al cargar la pagina
    btnEnviar.prop('disabled', true);
	visualTimer(btnEnviar);
})

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
	
	$.post("../../controllers/EmailController.php?op=confirmed_email", { email : email}, function(data) {
		data = JSON.parse(data);
		if(data.status){
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
					var newURL = window.location.href.split('?')[0];
		            window.history.replaceState({}, document.title, newURL);
		            // Recargar la pagina
		            location.reload();
				}
			});
		}else{
			swal("Error", data.msg, "error");
			$('#submitted_email')[0].reset();
        }
	});
});

function visualTimer(btnEnviar) {
    var tiempoRestante = 5;
    var temporizadorVisual = setInterval(function() {
        btnEnviar.html('Enviando correo (' + tiempoRestante + 's)');
        tiempoRestante--;
        
        if (tiempoRestante < 0) {
            clearInterval(temporizadorVisual);
            btnEnviar.prop('disabled', false);
            btnEnviar.html('Enviar Correo');
        }
    }, 1000);
}