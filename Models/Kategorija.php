<?php
require_once __DIR__ . "/../DB/DB.php";
require_once "Redirect.php";

class Kategorija{

    private static function validateNaziv(string $naziv){
        $naziv = trim($naziv);

        if(strlen($naziv)<2){
            $msg="Naziv kategorije mora imati minimalno 2 znaka";
            Redirect::redirectToErrorPage($msg);
            exit;
        }
    }

    public static function allCategories(): array{
        $db = DB::getInstance()->conn;
        $sql = "SELECT * FROM kategorije";
        $result = $db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function insert($naziv){
        self::validateNaziv($naziv);
        $db = DB::getInstance()->conn;
        

        try{
            $stmt = $db->prepare("INSERT INTO kategorije (naziv) values (?)");
            $stmt->bind_param("s",$naziv);
            return $stmt->execute();
        }
        catch(mysqli_sql_exception $e){
            die("Greška: ".$e->getMessage());
        }
    }

    public static function getById($id){
        $db = DB::getInstance()->conn;

        $stmt = $db->prepare("SELECT * from kategorije WHERE id = ?");
        $stmt->bind_param("i",$id);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();      
    }

    public static function update($id,$naziv){
        $db = DB::getInstance()->conn;

        $stmt = $db->prepare("UPDATE kategorije set naziv = ? where id = ?");
        $stmt->bind_param("si",$id);
        $_SESSION["poruka"]="Kategorija uspiješno izbrisana";
        return $stmt->execute();
    }

    public static function delete($id){
        $db = DB::getInstance()->conn;
        try{
            $stmt = $db->prepare("DELETE FROM kategorije WHERE id = ?");
            $stmt->bind_param("i",$id);
            $_SESSION["poruka"]="Kategorija uspješno izbrisana!";
            return $stmt->execute();
        }
        catch(mysqli_sql_exception $e){
            //die("Greška u brisanju: ".$e->getMessage());
            Redirect::redirectToErrorPage($e->getMessage());
        }
        
    }
}

?>