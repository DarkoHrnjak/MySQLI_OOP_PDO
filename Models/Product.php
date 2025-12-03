<?php
require_once __DIR__ . "/../DB/DB.php";

require_once "Redirect.php";

class Produkt{

    private static function validateProdukt(int $cijena, float $kolicina){

        $errors = false;
        if($kolicina < 10){
            $msg="Količina je manja od 10";
            $errors = true;
        }
        if($cijena < 5){
            $errors=true;
            $msg.="<br>Cijena je manja od 5";
        }
        $errors == true ? Redirect::redirectToErrorPage($msg) : "";
    }

    public static function allProducts($sort = "asc"): array{
        $db = DB::getInstance()->conn;
        $sql = "SELECT p.*, k.naziv as kategorija
                from produkti p inner join kategorije k
                on p.kategorijaid = k.id order by p.id $sort";

        $result = $db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function insert($naziv,$kolicina,$cijena,$kategorijaid){
        self::validateProdukt($cijena,$kolicina);
        $db = DB::getInstance()->conn;

        try{
            $stmt = $db->prepare("INSERT INTO produkti (naziv,kolicina,cijena,kategorijaid) values (?,?,?,?)");
            $stmt->bind_param("sidi",$naziv,$kolicina,$cijena,$kategorijaid);
            return $stmt->execute();
        }
        catch(mysqli_sql_exception $e){
            $msg="Greška kod unosa: ".$e->getMessage();
            Redirect::redirectToErrorPage($msg);
            exit;
        }
    }

    public static function getById($id){
        $db = DB::getInstance()->conn;

        $stmt = $db->prepare("SELECT * from produkti WHERE id = ?");
        $stmt->bind_param("i",$id);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();      
    }

    public static function update($id,$naziv,$kolicina,$cijena,$kategorijaid){
        $db = DB::getInstance()->conn;
        try{
        $stmt = $db->prepare("UPDATE produkti set naziv = ?, kolicina=?, cijena=?, kategorijaid=? where id = ?");
        $stmt->bind_param("sidii",$naziv,$kolicina,$cijena,$kategorijaid,$id);
        $_SESSION["poruka"]="Proizvod naziva {$naziv} uspješno ažuriran!";
        return $stmt->execute();       
        }
        catch(mysqli_sql_exception $e){
            $msg="Greška kod ažuriranja: ".$e->getMessage();
            Redirect::redirectToErrorPage($msg);
            exit;
        }

    }

    public static function delete($id){
        $db = DB::getInstance()->conn;
        try{
            $stmt = $db->prepare("DELETE FROM produkti WHERE id = ?");
            $stmt->bind_param("i",$id);
            $_SESSION["poruka"]="Proizvod uspješno izbrisan!";
            return $stmt->execute();    
        }
        catch(mysqli_sql_exception $e){
            $msg="Greška kod brisanja: ".$e->getMessage();
            Redirect::redirectToErrorPage($msg);
            exit;
        }

    }

    
}

?>