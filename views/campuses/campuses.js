var tabla;

function init()
{
	$('#campuse_form').on("submit", function(e){
		insertOrUpdate(e);
	});
}

function insertOrUpdate(e)
{
	e.preventDefault();
	var formData = new FormData($('#campuse_form')[0]);
	
	var camposVacios = false;
	
    formData.forEach(function(value, key){
	    // Excluir id del chequeo de campos vacios
	    if (key !== 'idr') {
	        if (value === "") {
	            camposVacios = true;
	            return false;  // Para salir del bucle si se encuentra un campo vacio
	        }
	    }
	});
    
    if(camposVacios){
        swal("Error!", "Todos los campos son necesarios", "error");
        return false;
    }
	$.ajax({
		url: "../../controllers/CampuseController.php?op=createOrUpdate",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function(data){
			data = JSON.parse(data);
			if(data.status){
				$('#campuse_form')[0].reset();
				$('#modalGestionCampuse').modal('hide');
				$('#campuse_data').DataTable().ajax.reload();
	        	swal({
					title: "ColPaz Quipama",
					text: data.msg,
					type: "success",
					confirmButtonClass: "btn-success"
				});
			}else{
				swal("Atencion", data.msg, "error");
			}
		}
	});
}

$(document).ready(function(){
	tabla = $('#campuse_data').dataTable({
		"aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        "searching": true,
        lengthChange: false,
        colReorder: true,
        buttons: [		          
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
        ],
		"ajax":{
			url: '../../controllers/CampuseController.php?op=index',
			type: 'POST',
			dataType: 'JSON',
			error: function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy": true,
        "responsive": true,
        "bInfo":true,
        "iDisplayLength": 5,
        "autoWidth": false,
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
	}).DataTable();
});

function editar(idr){
	$('#mdltitulo').html('Editar Registro');
	
	$.post("../../controllers/CampuseController.php?op=show", { idr : idr}, function(data) {
    	data = JSON.parse(data);
    	$('#idr').val(data.idr);
    	$('#name').val(data.name);
    	$('#description').val(data.description);
    });
	
	$('#modalGestionCampuse').modal('show');
}

function ver(id)
{
	window.open("http://localhost/plataforma-web-colpaz/views/campuses/view?id="+id);
}

function eliminar(idr){
	swal({
    	title: "ColPaz Quipama",
    	text: "¿Esta seguro de eliminar la sede?",
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
			$.post("../../controllers/CampuseController.php?op=delete", { idr : idr}, function(data) {
        	});
        	
        	$('#campuse_data').DataTable().ajax.reload();
        	
			swal({
				title: "ColPaz Quipama",
				text: "Registro eliminado.",
				type: "success",
				confirmButtonClass: "btn-success"
			});
		}
	});
}

$(document).on("click", "#btnnuevo", function(){
	document.querySelector('#idr').value = '';
	$('#mdltitulo').html('Nuevo Registro');
	$('#campuse_form')[0].reset();
	$('#modalGestionCampuse').modal('show');
});

init();