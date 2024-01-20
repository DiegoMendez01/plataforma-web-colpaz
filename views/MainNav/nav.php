<nav class="side-menu">
    <ul class="side-menu-list">
    	<li class="blue-dirty">
    		<a href="..\Home\">
				<i class="font-icon font-icon-home"></i>
				<span class="lbl">Inicio</span>
			</a>
		</li>
		<?php 
		if($_SESSION['role_id'] == 1 OR $_SESSION['role_id'] == 2){
        ?>
            <li class="blue-dirty with-sub">
                <span>
                    <i class="font-icon font-icon-notebook"></i>
                    <span class="lbl">Gestion Cursos</span>
                </span>
                <ul>
                    <li><a href="..\Courses\"><span class="lbl">Cursos</span><span class="label label-custom label-pill label-danger">New</span></a></li>
                    <li><a href="..\UserCourses\"><span class="lbl">Cursos Usuarios</span><span class="label label-custom label-pill label-danger">New</span></a></li>
                </ul>
            </li>
            <li class="blue-dirty with-sub">
                <span>
                    <i class="font-icon font-icon-users"></i>
                    <span class="lbl">Gestion Usuarios</span>
                </span>
                <ul>
                    <li><a href="..\Users\"><span class="lbl">Usuarios</span><span class="label label-custom label-pill label-danger">New</span></a></li>
                    <li><a href="..\Zones\"><span class="lbl">Zonas</span><span class="label label-custom label-pill label-danger">New</span></a></li>
                    <li><a href="..\Roles\"><span class="lbl">Roles</span><span class="label label-custom label-pill label-danger">New</span></a></li>
                </ul>
            </li>
            <li class="blue-dirty with-sub">
                <span>
                    <i class="font-icon font-icon-contacts"></i>
                    <span class="lbl">Gestion Grados</span>
                </span>
                <ul>
                    <li><a href="..\Classrooms\"><span class="lbl">Grados</span><span class="label label-custom label-pill label-danger">New</span></a></li>
                </ul>
            </li>
            <li class="blue-dirty with-sub">
                <span>
                    <i class="font-icon font-icon-doc"></i>
                    <span class="lbl">Gestion Periodos</span>
                </span>
                <ul>
                    <li><a href="..\Periods\"><span class="lbl">Periodo Academico</span><span class="label label-custom label-pill label-danger">New</span></a></li>
                </ul>
            </li>
		<?php 
		}elseif($_SESSION['role_id'] == 3){
        ?>
        	<li class="blue-dirty">
    			<a href="..\Courses\">
    				<span class="glyphicon glyphicon-th"></span>
    				<span class="lbl">Mis Cursos</span>
    			</a>
    		</li>
        <?php 
        }
        ?>
	</ul>
</nav>