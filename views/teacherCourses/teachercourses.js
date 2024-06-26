var tabla;
// Variable de bandera para controlar si se ha adjuntado el manejador de eventos change para cada combobox
var degreeChangeAttached    = false;
var classroomChangeAttached = false;

function init()
{
	$('#teachercourse_form').on("submit", function(e){
		insertOrUpdate(e);
	});
}

function insertOrUpdate(e)
{
	e.preventDefault();
	var formData = new FormData($('#teachercourse_form')[0]);
	
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
    } else {
    	$.ajax({
			url: "../../controllers/TeacherCourseController.php?op=createOrUpdate",
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			success: function(data){
				data = JSON.parse(data);
				if(data.status){
					$('#teachercourse_form')[0].reset();
					$('#modalGestionTeacherCourse').modal('hide');
					$('#teachercourse_data').DataTable().ajax.reload();
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
}

$(document).ready(function(){
	tabla = $('#teachercourse_data').dataTable({
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
			url: '../../controllers/TeacherCourseController.php?op=index',
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
    $("#teachercourse_form")[0].reset();
    
    // Restablecer las variables de control de eventos de cambio
    degreeChangeAttached = false;
    classroomChangeAttached = false;
    
    generarCombos()
    
    $.post("../../controllers/TeacherCourseController.php?op=show", { id : id}, function(data) {
        data = JSON.parse(data);
        $('#id').val(data.id);
        $('#degree_id').val(data.degree_id);
        $('#user_id').val(data.user_id).trigger('change');
        $('#period_id').val(data.period_id).trigger('change');
        $('#course_id').val(data.course_id).trigger('change');
        $('#classroom_id').val(data.classroom_id);
    });
    
    $('#modalGestionTeacherCourse').modal('show');
}

function eliminar(id){
	swal({
    	title: "ColPaz Quipama",
    	text: "¿Esta seguro de eliminar el curso profesor?",
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
			$.post("../../controllers/TeacherCourseController.php?op=delete", { id : id}, function(data) {
        	});
        	
        	$('#teachercourse_data').DataTable().ajax.reload();
        	
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
	$('#teachercourse_form')[0].reset();
		// Restablecer las variables de control de eventos de cambio
    degreeChangeAttached = false;
    classroomChangeAttached = false;
    
	generarCombos()
	$('#modalGestionTeacherCourse').modal('show');
});

// Cuando cambia el valor del combobox de grado
$("#degree_id").change(function() {
    if (!classroomChangeAttached) {
        var selectedDegree = $(this).val(); // Obtener el valor seleccionado
        // Realizar una solicitud para obtener los salones de clase filtrados
        $.post("../../controllers/ClassroomController.php?op=combo", { degree_id: selectedDegree }, function(data) {
            $("#classroom_id").html(data); // Actualizar el combobox de salones de clase con los datos filtrados
        });
        degreeChangeAttached = true; // Establecer la bandera a verdadero para indicar que se ha adjuntado el manejador de eventos change
    }
});

// Cuando cambia el valor del combobox de aula
$("#classroom_id").change(function() {
    if (!degreeChangeAttached) {
        var selectedClassroom = $(this).val(); // Obtener el valor seleccionado
        // Realizar una solicitud para obtener los grados filtrados
        $.post("../../controllers/DegreeController.php?op=combo", { classroom_id : selectedClassroom }, function(data) {
            $("#degree_id").html(data); // Actualizar el combobox de grados con los datos filtrados
        });
        
        classroomChangeAttached = true; // Establecer la bandera a verdadero para indicar que se ha adjuntado el manejador de eventos change
    }
});

function ver(id)
{
	window.open("http://localhost/plataforma-web-colpaz/views/teacherCourses/view?id="+id);
}

// Funcion para generar combos
function generarCombos() {
    $.post("../../controllers/DegreeController.php?op=combo", function (data) {
        $("#degree_id").html(data);
    });
    
    $.post("../../controllers/UserController.php?op=comboTeacher", function (data) {
        $("#user_id").html(data);
    });

    $.post("../../controllers/CourseController.php?op=combo", function (data) {
        $("#course_id").html(data);
    });
    
    $.post("../../controllers/PeriodController.php?op=combo", function (data) {
        $("#period_id").html(data);
    });
    
    $.post("../../controllers/ClassroomController.php?op=combo", function (data) {
        $("#classroom_id").html(data);
    });
}

init();