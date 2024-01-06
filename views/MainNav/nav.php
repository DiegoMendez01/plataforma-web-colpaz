<nav class="side-menu">
    <ul class="side-menu-list">
    	<li class="blue-dirty">
    		<a href="..\Home\">
				<span class="glyphicon glyphicon-th"></span>
				<span class="lbl">Inicio</span>
			</a>
		</li>
		<?php 
		if($_SESSION['role_id'] == 1 OR $_SESSION['role_id'] == 2){
        ?>
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
    			<a href="..\Classrooms\">
    				<span class="glyphicon glyphicon-th"></span>
    				<span class="lbl">Gestion Grados</span>
    			</a>
    		</li>
			<li class="blue-dirty">
    			<a href="..\UserCourses\">
    				<span class="glyphicon glyphicon-th"></span>
    				<span class="lbl">Cursos Usuarios</span>
    			</a>
    		</li>
		<?php 
		}elseif($_SESSION['role_id'] == 3){
        ?>
        	<li class="blue-dirty">
    			<a href="..\UserCourses\">
    				<span class="glyphicon glyphicon-th"></span>
    				<span class="lbl">Cursos Usuarios</span>
    			</a>
    		</li>
        <?php 
        }
        ?>
	</ul>
</nav>