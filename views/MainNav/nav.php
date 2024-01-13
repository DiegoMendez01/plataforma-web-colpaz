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
        	<label style="margin-left: 20px; font-weight: bold;">Gestión Cursos</label>
        	<li class="blue-dirty">
    			<a href="..\Courses\">
    				<span class="glyphicon glyphicon-th"></span>
    				<span class="lbl">Cursos</span>
    			</a>
    		</li>
    		<li class="blue-dirty">
    			<a href="..\UserCourses\">
    				<span class="glyphicon glyphicon-th"></span>
    				<span class="lbl">Cursos Usuarios</span>
    			</a>
    		</li>
    		<li class="blue-dirty">
    			<a href="..\CourseClassrooms\">
    				<span class="glyphicon glyphicon-th"></span>
    				<span class="lbl">Cursos Grados</span>
    			</a>
    		</li>
        	<label style="margin-left: 20px; font-weight: bold;">Gestión Usuarios</label>
    		<li class="blue-dirty">
    			<a href="..\Users\">
    				<span class="glyphicon glyphicon-th"></span>
    				<span class="lbl">Usuarios</span>
    			</a>
    		</li>
    		<li class="blue-dirty">
    			<a href="..\Roles\">
    				<span class="glyphicon glyphicon-th"></span>
    				<span class="lbl">Roles</span>
    			</a>
    		</li>
    		<label style="margin-left: 20px; font-weight: bold;">Gestión Grados</label>
    		<li class="blue-dirty">
    			<a href="..\Classrooms\">
    				<span class="glyphicon glyphicon-th"></span>
    				<span class="lbl">Grados</span>
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