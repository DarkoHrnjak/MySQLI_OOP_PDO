<?php
require "../header.php";
require_once "../Models/Kategorija.php";
?>

<div id="content">

<h2>Nova kategorija</h2>

<?php

if(isset($_GET["id"])){
    $idkat=$_GET["id"];
    $kategorija = Kategorija::getById($idkat);
}
else
{
    $kategorija=null;
    $idkat=0;
}

?>

<form action="" method="POST">
    <input type="hidden" name="id" value="<?= $idkat ?>">
    <label>Naziv:</label>
    <input type="text" name="naziv" value="<?= $kategorija ? $kategorija["naziv"] : "" ?>">
    <button type="submit">Spremi</button>
</form>

<?php
if($_POST){
    if($_POST["id"]==0){
        Kategorija::insert($_POST["naziv"]);
        echo "<p style='color:green;'>Kategorija spremljena</p>";
    }
    else
    {
        //za update
        Kategorija::update($_POST["id"],$_POST["naziv"]);
        echo "<p style='color:green;'>Kategorija ažurirana</p>";
    }
    
    header("refresh: 1; url=kategorije.php");
}
?>
</div>

<?php require "../footer.php"; ?>