var tabla;

function init()
{
	$('#studentteacher_form').on("submit", function(e){
		insertOrUpdate(e);
	});
}

function insertOrUpdate(e)
{
	e.preventDefault();
	var formData = new FormData($('#studentteacher_form')[0]);
	
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
        swal("Error!", "Todos los campos son necesarios", "error");
        return false;
    }
    
	$.ajax({
		url: "../../controllers/StudentTeacherController.php?op=insertOrUpdate",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function(data){
			data = JSON.parse(data);
			if(data.status){
				$('#studentteacher_form')[0].reset();
				$('#modalGestionStudentTeacher').modal('hide');
				$('#studentteacher_data').DataTable().ajax.reload();
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
	tabla = $('#studentteacher_data').dataTable({
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
			url: '../../controllers/StudentTeacherController.php?op=listStudentTeachers',
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
	
	$.post("../../controllers/StudentTeacherController.php?op=listStudentTeacherById", { id : id}, function(data) {
    	data = JSON.parse(data);
    	$('#id').val('');
    	$('#user_id').empty();
    	$('#teacher_course_id').empty();
    	$('#period_id').empty();
    	$('#id').val(data.id);
    	
    	$.post("../../controllers/UserController.php?op=listUsers", function (users) {
			jsonData = JSON.parse(users);
	        $('#user_id').empty();
			
		    // Puedes iterar sobre los usuarios si hay mas de uno
		    jsonData.forEach(function(user) {
				if(user.role_id == 4){
			        // Crear una opcion para cada usuario y agregarla al desplegable
			        $('#user_id').append('<option value="' + user.id + '">' + user.name + ' ' + user.lastname + '</option>');
		    	}
		    });
		    $('#user_id').val(data.user_id);
	    });
	    
	    // Fetch courses and populate the course dropdown
	    $.post("../../controllers/PeriodController.php?op=listPeriods", function (periods) {
			jsonData = JSON.parse(periods);
	        $('#period_id').empty();
		
		    // Puedes iterar sobre los cursos si hay mas de uno
		    jsonData.forEach(function(period) {
		        // Crear una opcion para cada curso y agregarla al desplegable
		        $('#period_id').append('<option value="' + period.id + '">' + period.name + '</option>');
		    });
		    $('#period_id').val(data.period_id);
	    });
	    
	    // Fetch courses and populate the course dropdown
	    $.post("../../controllers/TeacherCourseController.php?op=getTeacherCourses", function (studentteachers) {
			jsonData = JSON.parse(studentteachers);
	        $('#teacher_course_id').empty();
		
		    // Puedes iterar sobre los cursos si hay mas de uno
		    jsonData.forEach(function(studentteacher) {
		        // Crear una opcion para cada curso y agregarla al desplegable
		        $('#teacher_course_id').append('<option value="' + studentteacher.id + '"> Profesor: '+studentteacher.nameTeacher+', Grado: '+studentteacher.nameDegree+',Aula: '+studentteacher.nameClassroom+', Materia:' +studentteacher.nameCourse+ '</option>');
		    });
		    $('#teacher_course_id').val(data.teacher_course_id);
	    });
    });
	
	$('#modalGestionStudentTeacher').modal('show');
}

function eliminar(id){
	swal({
    	title: "ColPaz Quipama",
    	text: "¿Esta seguro de eliminar el alumno profesor?",
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
			$.post("../../controllers/StudentTeacherController.php?op=deleteStudentTeacherById", { id : id}, function(data) {
        	});
        	
        	$('#studentteacher_data').DataTable().ajax.reload();
        	
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
	$('#studentteacher_form')[0].reset();
	// Fetch users and populate the user dropdown
    $.post("../../controllers/UserController.php?op=listUsers", function (data) {
		jsonData = JSON.parse(data);
        $('#user_id').empty();
	
	    // Puedes iterar sobre los usuarios si hay mas de uno
	    jsonData.forEach(function(user) {
			if(user.role_id == 4){
		        // Crear una opcion para cada usuario y agregarla al desplegable
		        $('#user_id').append('<option value="' + user.id + '">' + user.name + ' ' + user.lastname + '</option>');
	        }
	    });
    });
    
    // Fetch courses and populate the course dropdown
    $.post("../../controllers/PeriodController.php?op=listPeriods", function (periods) {
		jsonData = JSON.parse(periods);
        $('#period_id').empty();
	
	    // Puedes iterar sobre los cursos si hay mas de uno
	    jsonData.forEach(function(period) {
	        // Crear una opcion para cada curso y agregarla al desplegable
	        $('#period_id').append('<option value="' + period.id + '">' + period.name + '</option>');
	    });
	    $('#period_id').val(data.period_id);
    });
    
    // Fetch courses and populate the course dropdown
    $.post("../../controllers/TeacherCourseController.php?op=getTeacherCourses", function (studentteachers) {
		jsonData = JSON.parse(studentteachers);
        $('#teacher_course_id').empty();
	
	    // Puedes iterar sobre los cursos si hay mas de uno
	    jsonData.forEach(function(studentteacher) {
	        // Crear una opcion para cada curso y agregarla al desplegable
	        $('#teacher_course_id').append('<option value="' + studentteacher.id + '"> Profesor: '+studentteacher.nameTeacher+', Grado: '+studentteacher.nameDegree+',Aula: '+studentteacher.nameClassroom+', Materia:' +studentteacher.nameCourse+ '</option>');
	    });
	    $('#teacher_course_id').val(data.student_teacher_id);
    });
	
	$('#modalGestionStudentTeacher').modal('show');
});

init();