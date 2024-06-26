<?php

require_once(__DIR__ . "../../../docs/Route.php");
require_once(__DIR__ . "../../../docs/Session.php");
require_once("../../models/Menus.php");

$session = Session::getInstance();
$menu    = new Menus();

$menus   = $menu->getMenusByRole($session->get('role_id'), $session->get('idr'));

?>

<nav class="side-menu">
    <ul class="side-menu-list">
        <?php foreach($menus as $row){
            if($row['group'] == 'Dashboard' AND $row['permission'] == "Si"){
            ?>
                <li>
                    <a href="<?php echo $row["route"]; ?>">
                        <i class="font-icon font-icon-home"></i>
                        <span class="lbl"><?php echo $row["name"]; ?></span>
                        <span class="label label-custom label-pill label-danger">New</span>
                    </a>
                </li>
            <?php
            }
        }?>
        <li class="blue-dirty with-sub">
            <span>
                <i class="font-icon font-icon-notebook"></i>
                <span class="lbl">Gestion</span>
            </span>
            <ul>
                <?php foreach($menus as $row){
                if($row['group'] == 'Gestion' AND $row['permission'] == "Si"){
                ?>
         		   	<li>
         		   		<a href="<?php echo $row["route"]; ?>">
         		   			<span class="lbl"><?php echo $row["name"]; ?></span>
         		   		</a>
         		   	</li>
                <?php
                }
            }?>
            </ul>
        </li>
		<?php
        if($session->get('role_id') == 3) {
            require_once("../../models/TeacherCourses.php");
        
            $teacherCourse = new TeacherCourses();
            $dataAll = $teacherCourse->getTeacherCourseByIdUser($session->get('id'), $session->get('idr'));
            ?>
        
            <li class="blue-dirty with-sub">
                <span>
                    <i class="font-icon font-icon-user"></i>
                    <span class="lbl">Mis Cursos</span>
                </span>
                <?php if ($dataAll['row'] > 0) { ?>
                    <ul>
                        <?php while ($data = $dataAll['query']->fetch()) { ?>
                            <li>
                                <a href="../contents/index?course=<?= $data['id'] ?>">
                                    <span class="lbl"><?= $data['nameCourse']; ?> - <?= $data['nameDegree']; ?> - <?= $data['nameClassroom'] ?></span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </li>
        
        <?php
        }
        if($session->get('role_id') == 5)
        {
        ?>
        	<li class="blue-dirty">
        		<a href="..\home\submitted">
    				<i class="font-icon font-icon-mail"></i>
    				<span class="lbl">Envio de Confirmacion</span>
    			</a>
			</li>
        <?php
        }
        ?>
	</ul>
</nav>