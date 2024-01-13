var tabla;

function init()
{
	$('#courseclassroom_form').on("submit", function(e){
		insertOrUpdate(e);
	});
}

function insertOrUpdate(e)
{
	e.preventDefault();
	var formData = new FormData($('#courseclassroom_form')[0]);
	
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
			url: "../../controllers/CourseClassroomController.php?op=insertOrUpdate",
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			success: function(data){
				$('#courseclassroom_form')[0].reset();
				$('#modalGestionCourseClassroom').modal('hide');
				$('#courseclassroom_data').DataTable().ajax.reload();
	        	swal({
					title: "ColPaz Quipama",
					text: "Registro completado.",
					type: "success",
					confirmButtonClass: "btn-success"
				});
			}
		});
    }
}

$(document).ready(function(){
	tabla = $('#courseclassroom_data').dataTable({
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
			url: '../../controllers/CourseClassroomController.php?op=listCourseClassroom',
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
	$.post("../../controllers/CourseClassroomController.php?op=listCourseClassroomById", { id : id}, function(data) {
    	data = JSON.parse(data);
    	$('#id').val('');
    	$('#classroom_id').empty();
    	$('#course_id').empty();
    	$('#id').val(data.id);
    	$.post("../../controllers/ClassroomController.php?op=listClassrooms", function (classrooms) {
			jsonData = JSON.parse(classrooms);
	        $('#classroom_id').empty();
		
		    // Puedes iterar sobre los usuarios si hay mas de uno
		    jsonData.forEach(function(classroom) {
		        // Crear una opcion para cada usuario y agregarla al desplegable
		        $('#classroom_id').append('<option value="' + classroom.id + '">' + classroom.name + '</option>');
		    });
		    $('#classroom_id').val(data.classroom_id);
	    });
	
	    // Fetch courses and populate the course dropdown
	    $.post("../../controllers/CourseController.php?op=listCourses", function (courses) {
			jsonData = JSON.parse(courses);
	        $('#course_id').empty();
		
		    // Puedes iterar sobre los cursos si hay mas de uno
		    jsonData.forEach(function(course) {
		        // Crear una opcion para cada curso y agregarla al desplegable
		        $('#course_id').append('<option value="' + course.id + '">' + course.name + '</option>');
		    });
		    $('#course_id').val(data.course_id);
	    });
    });
	
	$('#modalGestionCourseClassroom').modal('show');
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
			$.post("../../controllers/CourseClassroomController.php?op=deleteCourseClassroomsById", { id : id}, function(data) {
        	});
        	
        	$('#courseclassroom_data').DataTable().ajax.reload();
        	
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
	$('#mdltitulo').html('Nuevo Registro');
	$('#courseclassroom_form')[0].reset();
	// Fetch users and populate the user dropdown
    $.post("../../controllers/ClassroomController.php?op=listClassrooms", function (data) {
		jsonData = JSON.parse(data);
        $('#classroom_id').empty();
	
	    // Puedes iterar sobre los usuarios si hay mas de uno
	    jsonData.forEach(function(classroom) {
	        // Crear una opcion para cada usuario y agregarla al desplegable
	        $('#classroom_id').append('<option value="' + classroom.id + '">' + classroom.name + '</option>');
	    });
    });

    // Fetch courses and populate the course dropdown
    $.post("../../controllers/CourseController.php?op=listCourses", function (data) {
		jsonData = JSON.parse(data);
        $('#course_id').empty();
	
	    // Puedes iterar sobre los cursos si hay mas de uno
	    jsonData.forEach(function(course) {
	        // Crear una opcion para cada curso y agregarla al desplegable
	        $('#course_id').append('<option value="' + course.id + '">' + course.name + '</option>');
	    });
    });
	
	$('#modalGestionCourseClassroom').modal('show');
});

init();