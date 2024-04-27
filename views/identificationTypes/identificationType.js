var tabla;

function init()
{
	$('#mantenimiento_form').on("submit", function(e){
		insertOrUpdate(e);
	});
}

function insertOrUpdate(e)
{
	e.preventDefault();
	var formData = new FormData($('#mantenimiento_form')[0]);
	
	var camposVacios = false;
	
    formData.forEach(function(value, key){
	    // Excluir id del chequeo de campos vacios
	    if (key !== 'id') {
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
		url: "../../controllers/IdentificationTypeController.php?op=insertOrUpdate",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function(data){
			data = JSON.parse(data);
			if(data.status){
				$('#mantenimiento_form')[0].reset();
				$('#modalmantenimiento').modal('hide');
				$('#table_data').DataTable().ajax.reload();
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
	tabla = $('#table_data').dataTable({
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
			url: '../../controllers/IdentificationTypeController.php?op=listIdentificationType',
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

function editar(id){
	$('#mdltitulo').html('Editar Registro');
	
	$.post("../../controllers/IdentificationTypeController.php?op=listIdentificationTypeById", { id : id}, function(data) {
    	data = JSON.parse(data);
    	$('#id').val(data.id);
    	$('#name').val(data.name);
    });
	
	$('#modalmantenimiento').modal('show');
}

function ver(id)
{
	window.open("http://localhost/plataforma-web-colpaz/views/identificationTypes/view?id="+id);
}

function eliminar(id){
	swal({
    	title: "ColPaz Quipama",
    	text: "¿Esta seguro de eliminar el tipo de identificacion?",
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
			$.post("../../controllers/IdentificationTypeController.php?op=deleteIdentificationTypeById", { id : id}, function(data) {
        	});
        	
        	$('#table_data').DataTable().ajax.reload();
        	
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
	document.querySelector('#id').value = '';
	$('#mdltitulo').html('Nuevo Registro');
	$('#mantenimiento_form')[0].reset();
	$('#modalmantenimiento').modal('show');
});

init();