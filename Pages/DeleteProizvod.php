<?php
require_once "../Models/Product.php";

if(!isset($_GET['id'])){
    die("Nedostaje ID proizvoda!");
}

Product::delete($_GET['id']);

header("Location: proizvodi.php");

?>