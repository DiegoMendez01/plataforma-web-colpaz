<?php 

session_start();

class Database
{
    protected $dbh;
    
    protected function connection()
    {
        try{
            $conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=colpazdb","root","");
            return $conectar;
        }catch (Exception $e){
            print "¡Error BD!: ".$e->getMessage()."<br>";
            die();
        }
    }
    
    public function set_names()
    {
        return $this->dbh->query("SET NAMES 'utf8'");
    }
    
    public static function route()
    {
        return "http://localhost/plataforma-web-colpaz/";
    }
}

?>