<?php

require_once("../config/connection.php");
require_once("../models/IdentificationTypes.php");

$identificationType = new IdentificationTypes();

switch($_GET['op'])
{
    /*
     * Listar para comboBox
     */
    case 'combo':
        $datos = $identificationType->getIdentificationTypes();
        if(is_array($datos) == true AND count($datos) > 0){
            $html = "";
            $html.= "<option selected></option>";
            foreach($datos as $row){
                $html.= "<option value='".$row['id']."'>".$row['name']."</option>";
            }
            echo $html;
        }
        break;
}

?>