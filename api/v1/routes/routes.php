<?php

$routesArray = explode("/", $_SERVER['REQUEST_URI']);

if(count(array_filter($routesArray)) == 3){
    /*=====================================
     Cuando no se hace una peticion a la API
     =======================================*/
    $json = [
        "detail" => 'No encontrado'
    ];
    
    echo json_encode($json, true);
    return;
}else{
    /*====================================================
     Cuando pasamos solo un indice en el array $routesArray
     ======================================================*/
    if(count(array_filter($routesArray)) === 5 AND !is_numeric(array_filter($routesArray)[5])){
        /*====================================================
         Cuando se hacen peticiones según el nombre del indice
         ======================================================*/
        if(array_filter($routesArray)[4] == 'users'){
            if(isset($_SERVER['REQUEST_METHOD']) AND $_SERVER['REQUEST_METHOD'] == 'POST'){
                
            }elseif(isset($_SERVER['REQUEST_METHOD']) AND $_SERVER['REQUEST_METHOD'] == 'GET'){
                $users = new usersController();
                $users->view();
            }
        }
    }else{
        
    }
}

?>