<?php
require_once __DIR__ . "/../DB/DB.php";
require_once "Redirect.php";

class Kategorija{

    public int $id;
    public string $naziv;

    public static function allCategories(): array{
        $db = DB::getInstance()->connpdo;
        $sql = "SELECT * FROM kategorije";
        $reasult=$db->query($sql);

        return $reasult->fetchAll();
    }

    public static function insert($naziv){
        $db = DB::getInstance()->connpdo;

        try{
            $sql="INSERT INTO kategorije (naziv) values (:naziv)";
            $stmt=$db->prepare($sql);

            $ok = $stmt->execute(
                [
                    ':naziv'=>$naziv
                ]
            );
            return $ok;
        }
        catch(PDOException $e)
        {
            $msg=$e->getMessage();
            Redirect::redirectToErrorPage($msg);
        }
    }

    public static function getById($id){
        $db= DB::getInstance()->connpdo;

        $stmt = $db->prepare("SELECT * FROM kategorije where id = :id");
        $stmt->execute([':id'=>$id]);

        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function update($id,$naziv){
        $db= DB::getInstance()->connpdo;

        $sql="UPDATE kategorije set naziv = :naziv where id=:id";
        $stmt = $db->prepare($sql);

        $ok = $stmt->execute([
            ':id'=>$id,
            ':naziv'=>$naziv
        ]);

        return $ok;
    }

    public static function delete($id){
        $db = DB::getInstance()->connpdo;
        try{
            $sql = "DELETE from kategorije where id = :id";
            $stmt = $db->prepare($sql);
            return $stmt->execute([':id'=>$id]);
        }
        catch(PDOException $e){
            $msg="Greška: ".$e->getMessage();
            Redirect::redirectToErrorPage($msg);
            exit;
        }
    }

    public static function insertForTransation($naziv, PDO $db):int{
        $stmt=$db->prepare("INSERT INTO kategorije (naziv) values (:naziv)");
        $stmt->execute([':naziv'=>$naziv]);

        return $db->lastInsertId();
    }
}

?>