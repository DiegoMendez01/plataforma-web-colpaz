<?php 

require_once 'controllers/routesController.php';
require_once 'controllers/usersController.php';
require_once 'models/userModel.php';
require_once 'controllers/menuRolesController.php';
require_once 'models/menuRoleModel.php';

$rutas = new routesController();
$rutas->inicio();

?>