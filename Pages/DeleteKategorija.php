<?php
require_once "../Models/Kategorija.php";

if(!isset($_GET['id'])){
    die("Nedostaje ID kategorije!");
}

Kategorija::delete($_GET['id']);

header("Location: kategorije.php");

?>