var tabla;

var user_id = $('#user_idx').val();

function init()
{
	$('#user_form').on("submit", function(e){
		insertOrUpdate(e);
	});
	
	$('#userRol_form').on("submit", function(e){
		updateAsignRole(e);
	});
}

function updateAsignRole(e)
{
	e.preventDefault();
	var formData = new FormData($('#userRol_form')[0]);
	$.ajax({
		url: "../../controllers/UserController.php?op=updateAsignRole",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function(data){
			data = JSON.parse(data);
			if(data.status){
				$.post("../../controllers/emailController.php?op=change_role", { user_id : data.user_id, role_name : data.role_name}, function(data) {
	        	});
	        	
	        	$('#userRol_form')[0].reset();
				$('#modalAsignRole').modal('hide');
				$('#user_data').DataTable().ajax.reload();
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
	var formData = new FormData($('#user_form')[0]);
	
	var camposVacios = false;
	
    formData.forEach(function(value, key) {
		var idFieldValue = formData.get('id');
	    var isEditing    = idFieldValue !== null && idFieldValue !== undefined && idFieldValue !== '';
	
	    if (isEditing){
	        if(key !== "phone2" && key !== 'password_hash' && key !== 'repeatPass'){
	            if(value === ""){
	                camposVacios = true;
	                return false;
	            }
	        }
	    }else{
			// Excluir phone2 y id del chequeo de campos vacios
	        if(key !== "phone2" && key !== 'id'){
	            if(value === ""){
	                camposVacios = true;
	                return false;
	            }
	        }
	    }
	});
    
    if(camposVacios){
        swal("Error!", "Campos vacios", "error");
        return false;
    }
    
    var repeatPass   = formData.get('repeatPass');
    var password     = formData.get('password_hash');
    if (repeatPass === password) {
		formData.delete('repeatPass');
		var phone = formData.get('phone');
    	var phone2 = formData.get('phone2');
    	if(phone2 !== ""){
			if(phone2 !== phone){
            	$.ajax({
					url: "../../controllers/UserController.php?op=insertOrUpdate",
					type: "POST",
					data: formData,
					contentType: false,
					processData: false,
					success: function(data){
						data = JSON.parse(data);
						if(data.status){
					        $('#user_form')[0].reset();
							$('#modalGestionUsuario').modal('hide');
							$('#user_data').DataTable().ajax.reload();
							
				        	swal({
								title: "ColPaz Quipama",
								text: data.msg,
								type: "success",
								confirmButtonClass: "btn-success"
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
				swal("Error!", "Los celulares deben ser diferentes", "error");
			}
		}else{
			$.ajax({
				url: "../../controllers/UserController.php?op=insertOrUpdate",
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,
				success: function(data){
					data = JSON.parse(data);
					if(data.status){
				        $('#user_form')[0].reset();
						$('#modalGestionUsuario').modal('hide');
						$('#user_data').DataTable().ajax.reload();
			        	swal({
							title: "ColPaz Quipama",
							text: data.msg,
							type: "success",
							confirmButtonClass: "btn-success"
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
}

$(document).ready(function(){
	tabla = $('#user_data').dataTable({
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
			url: '../../controllers/UserController.php?op=listUser',
			type: 'POST',
			dataType: 'JSON',
			data: {
		        id: user_id
		    },
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
        } 
	}).DataTable();
});

function editar(id){
	$('#mdltitulo').html('Editar Registro');
	
	$.post("../../controllers/UserController.php?op=listUserById", { id : id}, function(data) {
    	data = JSON.parse(data);
    	$('#id').val(data.id);
    	$('#name').val(data.name);
    	$('#lastname').val(data.lastname);
    	$('#username').val(data.username);
    	$('#email').val(data.email);
    	$('#identification_type_id').val(data.identification_type_id).trigger('change');
    	$('#identification').val(data.identification);
    	$('#phone').val(data.phone);
    	$('#phone2').val(data.phone2);
    	$('#birthdate').val(data.birthdate);
    	$('#sex').val(data.sex).trigger('change');
    });
	
	$('#modalGestionUsuario').modal('show');
}

function eliminar(id){
	swal({
    	title: "ColPaz Quipama",
    	text: "¿Esta seguro de eliminar el usuario?",
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
			$.post("../../controllers/UserController.php?op=deleteUserById", { id : id}, function(data) {
        	});
        	
        	$('#user_data').DataTable().ajax.reload();
        	
			swal({
				title: "ColPaz Quipama",
				text: "Registro eliminado.",
				type: "success",
				confirmButtonClass: "btn-success"
			});
		}
	});
}

function editarRol(id)
{
	$.post("../../controllers/UserController.php?op=mostrar", { id : id }, function(data){
		data = JSON.parse(data);
		$('#user_id').val(data.id);
		$('#mdltitulo').html('Asignar rol de Usuario');
		$('#modalAsignRole').modal('show');
	});
}

$(document).on("click", "#btnnuevo", function(){
	document.querySelector('#id').value = '';
	$('#mdltitulo').html('Nuevo Registro');
	$('#user_form')[0].reset();
	$('#modalGestionUsuario').modal('show');
});

init();