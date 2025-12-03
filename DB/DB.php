<?php

class DB{

    private static ?DB $instance = null;

    public ?PDO $connpdo;

    private function __construct(){
        $dsn = "mysql:host=localhost;dbname=WebTrgovina;charset=utf8";
        $user="root";
        $pass="MyN3wStrongP@ss!";

        try{
            $this->connpdo = new PDO($dsn,$user,$pass,[
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
            echo "<br>Konekcija uspjesna";
        }
        catch(PDOException $e)
        {
            die("Greška s bazom: ".$e->getMessage());
        }
    }

    public static function getInstance(): DB{
        return self::$instance ??= new DB();
    }

    public function __destruct(){
        if($this->connpdo){
            $this->connpdo = null;
        }
    }

    
}

$db = DB::getInstance()->connpdo;

?>