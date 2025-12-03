<?php
require "../header.php";
require_once "../Models/Product.php";
require_once "../Models/Kategorija.php";
?>

<div id="content">

<h2>Novi proizvod</h2>

<?php

if(isset($_GET["id"])){
    $idpr=$_GET["id"];
    $produkt = Produkt::getById($idpr);
}
else
{
    $produkt=null;
    $idpr=0;
}
$kategorije = Kategorija::allCategories();
?>

<form action="" method="POST">
    <input type="hidden" name="id" value="<?= $idpr ?>">
    <label>Naziv:</label>
    <input type="text" name="naziv" value="<?= $produkt ? $produkt["naziv"] : "" ?>">
    <label>Količina:</label>
    <input type="text" name="kolicina" value="<?= $produkt ? $produkt["kolicina"] : "" ?>">
    <label>Cijena:</label>
    <input type="number" name="cijena" step="0.01" value="<?= $produkt ? $produkt["cijena"] : "" ?>">
    <label>Kategorija</label>
    <select name="kategorijaid">
        <?php foreach($kategorije as $k): ?>
            <option value="<?= $k['id'] ?>" 
            <?php if(isset($produkt) && $produkt["kategorijaid"]==$k["id"]) echo " selected"; ?>
            ><?= $k['naziv'] ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Spremi</button>
</form>

<?php
if($_POST){
    if($_POST["id"]==0){
        Produkt::insert($_POST["naziv"],$_POST["kolicina"],$_POST["cijena"],$_POST["kategorijaid"]);
        echo "<p style='color:green;'>Proizvod spremljen</p>";
    }
    else
    {
        //za update
        Produkt::update($_POST["id"],$_POST["naziv"],$_POST["kolicina"],$_POST["cijena"],$_POST["kategorijaid"]);
        echo "<p style='color:green;'>Proizvod ažuriran</p>";
    }
    
    header("refresh: 1; url=proizvodi.php");
}
?>
</div>

<?php require "../footer.php"; ?>