<?php

require_once "../header.php";
require_once "../Models/Kategorija.php";
require_once "../Models/Product.php";
require_once "../Models/Redirect.php";
require_once "../DB/DB.php";

$db = DB::getInstance()->connpdo;
$kategorije = Kategorija::allCategories();

?>
<div id="content">
    <h2>Dodavanje kategorije i proizvoda (transakcija)</h2>

    <form action="POST" action="">
        <label>Kategorija odabir:</label>
        <select name="kategorijaid" id="kategorijaid" onchange="change(this.value)">
            <option value="-1">--Odaberi--</option>
            <?php foreach($kategorije as $k): ?>
                <option value="<?= $k["id"] ?>"><?= $k["naziv"] ?></option>
            <?php endforeach; ?>
            <option value="new">+ Nova kategorija</option>
        </select>
        <div id="nova_kategorija_wrap" style="display:none; margin-top: 10px;">
        <label>Naziv kategorije</label>
        <input type="text" name="kategorija">
        </div>
 
        <label>Naziv proizvoda</label>
        <input type="text" name="naziv">
        <label>Količina</label>
        <input type="number" name="kolicina">
        <label>Cijena</label>
        <input type="number" step="0.01" name="naziv">
        <button type="submit">Spremi transakciju</button>
    </form>
    <?php
    if($_POST){
        $kategorijaid = $_POST["kategorijaid"];
        $nazivPro = $_POST["naziv"];
        $kolicina = $_POST["kolicina"];
        $cijena = $_POST["cijena"];

        try{
            $db->beginTransaction();

            if($kategorijaid==="new")
            {
                $nazivKat = $_POST["kategorija"];
                $newCatId= Kategorija::insertForTransation($nazivKat,$db);
            }
            else{
                $newCatId = (int)$kategorijaid;
            }

            $ok = Product::insertForTransation($naztivPro,$kolicina,$cijena,$newCatId,$db);
        
            if(!$ok){
                throw new Exception("Neuspješan unos proizvoda");
            }

            $db->commit();
            $_SESSION["poruka"]="Transakcija uspješno prošla";
            header("Location: proizvodi.php");
        }
        catch(Exception $e){
            $db->rollBack();
            Redirect::redirectToErrorPage($e->getMessage());
            exit;
        }
    }
    ?>
</div>
<?php
require_once "../footer.php";
?>
<script>
    function change(izbor){
        let wrap = document.getElementById("nova_kategorija_wrap");

        if(izbor==="new"){
            wrap.style.display = "block";//prikaži polje
        }
        else{
            wrap.style.display = "none";
        }
    }
</script>