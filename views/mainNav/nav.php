<nav class="side-menu">
    <ul class="side-menu-list">
    	<li class="blue-dirty">
    		<a href="..\home\">
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
                    <li><a href="..\courses\"><span class="lbl">Cursos</span><span class="label label-custom label-pill label-danger">New</span></a></li>
                    <li><a href="..\userCourses\"><span class="lbl">Cursos Usuarios</span><span class="label label-custom label-pill label-danger">New</span></a></li>
                </ul>
            </li>
            <li class="blue-dirty with-sub">
                <span>
                    <i class="font-icon font-icon-users"></i>
                    <span class="lbl">Gestion Usuarios</span>
                </span>
                <ul>
                    <li><a href="..\users\"><span class="lbl">Usuarios</span><span class="label label-custom label-pill label-danger">New</span></a></li>
                    <li><a href="..\userCourses\"><span class="lbl">Cursos Usuarios</span><span class="label label-custom label-pill label-danger">New</span></a></li>
                </ul>
            </li>
            <li class="blue-dirty with-sub">
                <span>
                    <i class="font-icon font-icon-contacts"></i>
                    <span class="lbl">Gestion Aulas</span>
                </span>
                <ul>
                    <li><a href="..\classrooms\"><span class="lbl">Aulas</span><span class="label label-custom label-pill label-danger">New</span></a></li>
                </ul>
            </li>
            <li class="blue-dirty with-sub">
                <span>
                    <i class="font-icon font-icon-doc"></i>
                    <span class="lbl">Gestion Grados</span>
                </span>
                <ul>
                    <li><a href="..\degrees\"><span class="lbl">Grados</span><span class="label label-custom label-pill label-danger">New</span></a></li>
                </ul>
            </li>
            <li class="blue-dirty with-sub">
                <span>
                    <i class="font-icon font-icon-doc"></i>
                    <span class="lbl">Gestion Periodos</span>
                </span>
                <ul>
                    <li><a href="..\periods\"><span class="lbl">Periodo Academico</span><span class="label label-custom label-pill label-danger">New</span></a></li>
                </ul>
            </li>
            <li class="blue-dirty with-sub">
                <span>
                    <i class="font-icon font-icon-users"></i>
                    <span class="lbl">Gestion Zonas</span>
                </span>
                <ul>
                    <li><a href="..\zones\"><span class="lbl">Zonas</span><span class="label label-custom label-pill label-danger">New</span></a></li>
                </ul>
            </li>
            <li class="blue-dirty with-sub">
                <span>
                    <i class="font-icon font-icon-users"></i>
                    <span class="lbl">Gestion Roles</span>
                </span>
                <ul>
                    <li><a href="..\roles\"><span class="lbl">Roles</span><span class="label label-custom label-pill label-danger">New</span></a></li>
                </ul>
            </li>
		<?php
		}
        if($_SESSION['role_id'] == 3) {
            require_once("../../models/UserCourses.php");
        
            $userCourse = new UserCourses();
            $dataAll = $userCourse->getUserCourseByTeacher($_SESSION['id']);
            ?>
        
            <li class="blue-dirty with-sub">
                <span>
                    <i class="font-icon font-icon-notebook"></i>
                    <span class="lbl">Mis Cursos</span>
                </span>
                <?php if ($dataAll['row'] > 0) { ?>
                    <ul>
                        <?php while ($data = $dataAll['query']->fetch()) { ?>
                            <li>
                                <a href="../contents/index.php?course=<?= $data['id'] ?>">
                                    <span class="lbl"><?= $data['nameCourse']; ?> - <?= $data['nameDegree']; ?> - <?= $data['nameClassroom'] ?></span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </li>
        
        <?php } ?>
	</ul>
</nav>