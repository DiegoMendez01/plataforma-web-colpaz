<?php 

require_once("../../docs/Session.php");
require_once("../../docs/Route.php");

$session = Session::getInstance();
$session->destroy();
header("Location:".Route::route()."views/site/");
exit;

?>