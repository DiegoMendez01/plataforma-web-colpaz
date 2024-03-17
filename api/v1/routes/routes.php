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
    if(count(array_filter($routesArray)) === 5){
        /*====================================================
         Cuando se hacen peticiones según el nombre del indice
         ======================================================*/
        if(!is_numeric(array_filter($routesArray)[5])){
            if(array_filter($routesArray)[5] == 'index'){
                if(array_filter($routesArray)[4] == 'users'){
                    if(isset($_SERVER['REQUEST_METHOD']) AND $_SERVER['REQUEST_METHOD'] == 'GET'){
                        $users = new usersController();
                        $users->view();
                    }
                }
            }else if(array_filter($routesArray)[5] == 'create'){
                if(array_filter($routesArray)[4] == 'users'){
                    if(isset($_SERVER['REQUEST_METHOD']) AND $_SERVER['REQUEST_METHOD'] == 'POST'){
                        // Leer datos del cuerpo de la solicitud (JSON)
                        $json_data = file_get_contents("php://input");
                        // Decodificar el JSON en un array asociativo
                        $data = json_decode($json_data, true);
                        
                        if ($data === null) {
                            // Error al decodificar JSON
                            $json = [
                                "status" => 400,
                                "message" => "Error en el formato JSON",
                            ];
                            echo json_encode($json, true);
                            return;
                        }
                        $users = new usersController();
                        $users->create($data);
                    }
                }
            }
        }else if(is_numeric(array_filter($routesArray)[5])){
            if(array_filter($routesArray)[4] == 'users'){
                if(isset($_SERVER['REQUEST_METHOD']) AND $_SERVER['REQUEST_METHOD'] == 'GET'){
                    $users = new usersController();
                    $users->view(array_filter($routesArray)[5]);
                }
            }
        }
    }else{
        
    }
}

?>