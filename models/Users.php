<?php 

class Users extends Connect
{
    /*
     * Funcion para guardar los datos del usuario en variables de SESSION que servira
     * para mantener esa data mientras el usuario se encuentra logeado y nos ayude a realizar
     * funciones correspondientes a lo largo de su uso. Por medio de los metodos $_POST recibimos
     * la data que viene del formulario de login para guardarlos en variables y validar la consulta
     * para luego guardarlas en las variables de session.
     */
    public function login()
    {
        $conectar = parent::connection();
        parent::set_names();
        
        //Validamos si la informacion viene vacia o no, cuando se inicia sesion
        if(isset($_POST["submit"])){
            $identification     = $_POST['identification'];
            $password_hash      = $_POST['password_hash'];
            
            if(empty($identification) AND empty($password_hash)){
                header("Location:".Connect::route()."views/login/login.php?m=2");
                exit;
            }else{
                $sql = "
                    SELECT
                        *
                    FROM
                        users
                    WHERE
                        identification = ? AND password_hash = ? AND is_active = 1
                ";
                
                $stmt = $conectar->prepare($sql);
                $stmt->bindValue(1, $identification);
                $stmt->bindValue(2, $password_hash);
                $stmt->execute();
                
                $result = $stmt->fetch();
                
                if(is_array($result) AND count($result) > 0){
                    $_SESSION['id']             = $result['id'];
                    $_SESSION['name']           = $result['name'];
                    $_SESSION['lastname']       = $result['lastname'];
                    $_SESSION['email']          = $result['email'];
                    $_SESSION['identification'] = $result['identification'];
                    $_SESSION['password_hash']  = $result['password_hash'];
                    $_SESSION['is_active']      = $result['is_active'];
                    $_SESSION['role_id']        = $result['role_id'];
                    header("Location:".Connect::route()."views/home/");
                    exit;
                }else{
                    header("Location:".Connect::route()."views/login.php?m=1");
                    exit;
                }
            }
        }
    }