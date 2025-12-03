<?php
session_start();
$base = str_replace(['\\','/'],DIRECTORY_SEPARATOR,$_SERVER["DOCUMENT_ROOT"]);//C:/xampp/www
$path = str_replace(['\\','/'],DIRECTORY_SEPARATOR,__DIR__);

$relative = str_replace($base,'',$path);

$appUrl = str_replace(DIRECTORY_SEPARATOR,'/',$relative).'/';
define("APP_URL",$appUrl);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Web Trgovina</title>
    <link rel="stylesheet" href="<?= APP_URL ?>css/stil.css">
</head>
<body>

<nav>
    <a href="<?= APP_URL ?>index.php">Početna</a>
    <a href="<?= APP_URL ?>Pages/kategorije.php">Kategorije</a>
    <a href="<?= APP_URL ?>Pages/proizvodi.php">Proizvodi</a>
</nav>
<hr>