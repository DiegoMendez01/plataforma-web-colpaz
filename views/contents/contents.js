function init()
{
}

$(document).on("click", "#btnnuevo", function(){
	$('#mdltitulo').html('Nuevo Registro');
	$('#content_form')[0].reset();
	$('#modalGestionContenido').modal('show');
});

init();