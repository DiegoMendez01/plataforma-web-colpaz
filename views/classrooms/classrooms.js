var tabla;

function init()
{
	$('#classroom_form').on("submit", function(e){
		insertOrUpdate(e);
	});

	$('#campuse_form').on("submit", function(e){
		updateAsignCampuse(e);
	});
}

function insertOrUpdate(e)
{
	e.preventDefault();
	var formData = new FormData($('#classroom_form')[0]);
	
	var camposVacios = false;
	
    formData.forEach(function(value, key) {
	    // Excluir id del chequeo de campos vacios
	    if (key !== 'id'){
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
		url: "../../controllers/ClassroomController.php?op=insertOrUpdate",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function(data){
			data = JSON.parse(data);
			if(data.status){
				$('#classroom_form')[0].reset();
				$('#modalGestionClassroom').modal('hide');
				$('#classroom_data').DataTable().ajax.reload();
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

function updateAsignCampuse(e)
{
	e.preventDefault();
	var formData = new FormData($('#campuse_form')[0]);
	$.ajax({
		url: "../../controllers/ClassroomController.php?op=updateAsignCampuse",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function(data){
			data = JSON.parse(data);
			if(data.status){
				$('#campuse_form')[0].reset();
				$('#modalAsignCampuse').modal('hide');
				$('#classroom_data').DataTable().ajax.reload();
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

$(document).ready(function(){
	$.post("../../controllers/DegreeController.php?op=combo",function(data){
        $("#degree_id").html(data);
    });

	$.post("../../controllers/CampuseController.php?op=combo", function(data){
		$('#idr').html(data);
	});
    
	tabla = $('#classroom_data').dataTable({
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
			url: '../../controllers/ClassroomController.php?op=listClassroom',
			type: 'POST',
			dataType: 'JSON',
			error: function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy": true,
        "responsive": true,
        "bInfo":true,
        "iDisplayLength": 10,
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
	
	$.post("../../controllers/ClassroomController.php?op=listClassroomById", { id : id}, function(data) {
    	data = JSON.parse(data);
    	$('#id').val(data.id);
    	$('#name').val(data.name);
		$('#degree_id').val(data.degree_id).trigger('change');
    });
	
	$('#modalGestionClassroom').modal('show');
}

function ver(id)
{
	window.open("http://localhost/plataforma-web-colpaz/views/classrooms/view?id="+id);
}

function eliminar(id){
	swal({
    	title: "ColPaz Quipama",
    	text: "¿Esta seguro de eliminar el aula academica?",
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
			$.post("../../controllers/ClassroomController.php?op=deleteClassroomById", { id : id}, function(data) {
        	});
        	
        	$('#classroom_data').DataTable().ajax.reload();
        	
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
	$.post("../../controllers/ClassroomController.php?op=listClassroomById", { id : id }, function(data){
		data = JSON.parse(data);
		$('#mdltitulo').html('Asignar sede');
		$('#campuse_form')[0].reset();
		$('#xid').val(data.id);
		$('#modalAsignCampuse').modal('show');
	});
}

$(document).on("click", "#btnnuevo", function(){
	document.querySelector('#id').value = '';
	$('#mdltitulo').html('Nuevo Registro');
	$('#classroom_form')[0].reset();
	$('#modalGestionClassroom').modal('show');
});

init();