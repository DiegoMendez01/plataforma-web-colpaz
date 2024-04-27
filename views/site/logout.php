<?php 

require_once("../../config/database.php");
session_destroy();
header("Location:".Database::route()."views/site/");
exit;

?>