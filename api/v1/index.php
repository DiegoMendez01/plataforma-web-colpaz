<?php 

require_once 'controllers/routesController.php';
require_once 'controllers/usersController.php';
require_once 'models/userModel.php';

$rutas = new routesController();
$rutas->inicio();

?>