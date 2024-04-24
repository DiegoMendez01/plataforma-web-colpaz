var tabla;

function init()
{
	$('#roles_form').on("submit", function(e){
		insertOrUpdate(e);
	});
	
	$('#updateCampuse_form').on("submit", function(e){
		updateAsignCampuse(e);
	});
}

function updateAsignCampuse(e)
{
	e.preventDefault();
	var formData = new FormData($('#updateCampuse_form')[0]);
	$.ajax({
		url: "../../controllers/RoleController.php?op=updateAsignCampuse",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function(data){
			data = JSON.parse(data);
			if(data.status){
	        	$('#updateCampuse_form')[0].reset();
				$('#modalAsignCampuse').modal('hide');
				$('#role_data').DataTable().ajax.reload();
				swal({
					title: "ColPaz Quipama",
					text: data.msg,
					type: "success",
					confirmButtonClass: "btn-success"
				});
			}else{
				swal("Advertencia", data.msg, "error");
			}
		}
	});
}

function insertOrUpdate(e)
{
	e.preventDefault();
	var formData = new FormData($('#roles_form')[0]);
	
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
		url: "../../controllers/RoleController.php?op=insertOrUpdate",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function(data){
			data = JSON.parse(data);
			if(data.status){
				$('#roles_form')[0].reset();
				$('#modalGestionRoles').modal('hide');
				$('#role_data').DataTable().ajax.reload();
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
	$.post("../../controllers/CampuseController.php?op=combo", function(data){
		$('#idr').html(data);
	});
	tabla = $('#role_data').dataTable({
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
			url: '../../controllers/RoleController.php?op=listRole',
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
	
	$.post("../../controllers/RoleController.php?op=listRoleById", { id : id}, function(data) {
    	data = JSON.parse(data);
    	$('#id').val(data.id);
    	$('#name').val(data.name);
    	$('#functions').val(data.functions);
    });
	
	$('#modalGestionRoles').modal('show');
}

function eliminar(id){
	swal({
    	title: "ColPaz Quipama",
    	text: "¿Esta seguro de eliminar el curso?",
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
			$.post("../../controllers/RoleController.php?op=deleteRoleById", { id : id}, function(data) {
        	});
        	
        	$('#role_data').DataTable().ajax.reload();
        	
			swal({
				title: "ColPaz Quipama",
				text: "Registro eliminado.",
				type: "success",
				confirmButtonClass: "btn-success"
			});
		}
	});
}

function editCampuse(id)
{
	$.post("../../controllers/RoleController.php?op=listRoleById", { id : id }, function(data){
		data = JSON.parse(data);
		$('#userx_id').val(data.id);
		$('#mdltitulo').html('Asignar sede de Usuario');
		$('#modalAsignCampuse').modal('show');
	});
}

function ver(id)
{
	window.open("http://localhost/plataforma-web-colpaz/views/roles/view?id="+id);
}

$(document).on("click", "#btnnuevo", function(){
	document.querySelector('#id').value = '';
	$('#mdltitulo').html('Nuevo Registro');
	$('#roles_form')[0].reset();
	$('#modalGestionRoles').modal('show');
});

init();