<?php

class DB{

    private static ?DB $instance = null;

    public mysqli $conn;

    public function __construct()  {

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try{
            $this->conn = new mysqli("localhost","root","MyN3wStrongP@ss!","WebTrgovina");
            $this->conn->set_charset("utf8");
            //echo "Konekcija uspješna";
        }
        catch(mysqli_sql_exception $e){
            die("Greška s bazom: ".$e->getMessage());
        }
        
    }

    public static function getInstance(): DB{
        return self::$instance ??= new DB();
    }

    public function __destruct(){
        if($this->conn){
            $this->conn->close();
        }
    }
}

?>