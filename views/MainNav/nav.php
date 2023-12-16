<?php 
if($_SESSION['role_id'] == 1){
?>
    <nav class="side-menu">
        <ul class="side-menu-list">
        	<li class="blue-dirty">
        		<a href="..\Home\">
    				<span class="glyphicon glyphicon-th"></span>
    				<span class="lbl">Inicio</span>
    			</a>
    		</li>
    		<li class="blue-dirty">
    			<a href="..\Users\">
    				<span class="glyphicon glyphicon-th"></span>
    				<span class="lbl">Gestion de Usuarios</span>
    			</a>
    		</li>
    		<li class="blue-dirty">
    			<a href="..\Courses\">
    				<span class="glyphicon glyphicon-th"></span>
    				<span class="lbl">Gestion Cursos</span>
    			</a>
    		</li>
    		<li class="blue-dirty">
    			<a href="..\Grades\">
    				<span class="glyphicon glyphicon-th"></span>
    				<span class="lbl">Gestion Grados</span>
    			</a>
    		</li>
    	</ul>
    </nav>
<?php 
}else if($_SESSION['role_id'] == 2){
?>
	<nav class="side-menu">
        <ul class="side-menu-list">
        	<li class="blue-dirty">
        		<a href="..\home\">
    				<span class="glyphicon glyphicon-th"></span>
    				<span class="lbl">Inicio</span>
    			</a>
    		</li>
    		<li class="blue-dirty">
    			<a href="#">
    				<span class="glyphicon glyphicon-th"></span>
    				<span class="lbl">Detalle Cursos</span>
    			</a>
    		</li>
    		<li class="blue-dirty">
    			<a href="#">
    				<span class="glyphicon glyphicon-th"></span>
    				<span class="lbl">Detalle Materias</span>
    			</a>
    		</li>
    		<li class="blue-dirty">
    			<a href="#">
    				<span class="glyphicon glyphicon-th"></span>
    				<span class="lbl">Detalle estudiantes</span>
    			</a>
    		</li>
    	</ul>
    </nav>
<?php 
}else if($_SESSION['role_id'] == 3){
?>
	<nav class="side-menu">
        <ul class="side-menu-list">
        	<li class="blue-dirty">
        		<a href="..\home\">
    				<span class="glyphicon glyphicon-th"></span>
    				<span class="lbl">Inicio</span>
    			</a>
    		</li>
    		<li class="blue-dirty">
    			<a href="#">
    				<span class="glyphicon glyphicon-th"></span>
    				<span class="lbl">Mi Curso</span>
    			</a>
    		</li>
    		<li class="blue-dirty">
    			<a href="#">
    				<span class="glyphicon glyphicon-th"></span>
    				<span class="lbl">Mis Materias</span>
    			</a>
    		</li>
    		<li class="blue-dirty">
    			<a href="#">
    				<span class="glyphicon glyphicon-th"></span>
    				<span class="lbl">Mis Amigos</span>
    			</a>
    		</li>
    	</ul>
    </nav>
<?php
}else{
?>
	<nav class="side-menu">
        <ul class="side-menu-list">
        	<li class="blue-dirty">
        		<a href="..\home\">
    				<span class="glyphicon glyphicon-th"></span>
    				<span class="lbl">Inicio</span>
    			</a>
    		</li>
    		<li class="blue-dirty">
    			<a href="#">
    				<span class="glyphicon glyphicon-th"></span>
    				<span class="lbl">Contacto</span>
    			</a>
    		</li>
    		<li class="blue-dirty">
    			<a href="#">
    				<span class="glyphicon glyphicon-th"></span>
    				<span class="lbl">Curso de prueba</span>
    			</a>
    		</li>
    	</ul>
    </nav>
<?php 
}
?>