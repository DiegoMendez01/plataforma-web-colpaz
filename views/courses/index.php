[8:36 p. m., 15/12/2023] Diego Méndez: <?php 

class Courses extends Connect
{
    /*
     * Funcion para insertar/registrar cursos por medio de un formulario
     */
    public function insertCourse($parent_id, $name, $description = null)
    {
        $conectar = parent::connection();
        parent::set_names();
        
        // Concatenar y formatear las credenciales para generar el API key
        $token = sprintf("%s-%s-%s-%s-%s", substr(md5($name), 0, 8), substr(md5($parent_id), 0, 4), substr(md5(uniqid()), 0, 4), substr(md5(uniqid()), 0, 4), substr(md5(uniqid()), 0, 8));
        
        $sql = "
            INSERT INTO
                courses (name, description, token, created)
            VALUES
                (?, ?, ?, ?, now())
        ";
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $parent_id);
        $stmt->bindValue(3, $description);
        $stmt->bindValue(4, $token);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
    /*
     * Funcion para traer todos los cursos registrados hasta el momento
     */
    public function getCourses()
    {
        $conectar = parent::connection();
        parent::set_names();
        
        $sql = "
            SELECT
                *
            FROM
                courses
            WHERE
                is_active = 1
        ";
        
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        
        return $result = $stmt->fetchAll();
    }
}

?>
[9:06 p. m., 15/12/2023] Diego Méndez: <?php

require_once("../../config/connection.php");

if(isset($_SESSION['id'])){
?>
<!DOCTYPE html>
<html>
<head lang="es">
	<?php
    require_once ("../mainHead/head.php");
    ?>
    <title>Aula Virtual::Gestion de Cursos</title>
</head>
<body class="with-side-menu">
	
	<?php
    require_once ("../mainHeader/header.php");
    ?>
	<!--.site-header-->

	<div class="mobile-menu-left-overlay"></div>
	
	<?php
    require_once ("../mainNav/nav.php");
    ?>
    
    <!-- Contenido  -->
	<div class="page-content">
		<div class="container-fluid">
			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Gestion Curso</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="../home/">Inicio</a></li>
								<li class="active">Gestion Curso</li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			
			<div class="box-typical box-typical-padding">
				<button type="button" id="btnnuevo" class="btn btn-inline btn-primary">Nuevo Registro</button>
				<table id="course_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
					<thead>
						<tr>
							<th style="width: 30%;">Nombre</th> 
							<th style="width: 30%;">Creado</th> 
							<th class="d-none d-sm-table-cell" style="width: 25%;">Estado</th>
							<th class="text-center" style="width: 5%"></th>
							<th class="text-center" style="width: 5%"></th>
							<th class="text-center" style="width: 5%"></th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				 </table>
			</div>
		</div>
	</div>
    
    <?php
    require_once("modalGestionCurso.php");
    ?>
    
    <?php
    require_once ("../mainJs/js.php");
    ?>
    <script src="courses.js" type="text/javascript"></script>
</body>
</html>
<?php 
}else{
    header("Location:" . Connect::route() . "views/login/");
    exit;
}
?>