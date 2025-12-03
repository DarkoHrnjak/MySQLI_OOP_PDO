<?php
require_once "../header.php";
require_once "../Models/Kategorija.php";

$kategorije = Kategorija::allCategories();
?>
<div id="content">
    <h2>Kategorije</h2>
    <p class="uspjeh">
        <?php
        if(isset($_SESSION["poruka"])){
            echo $_SESSION["poruka"];
            unset($_SESSION["poruka"]);
        }
        ?>
    </p>
    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>Naziv</th>
            <th>Akcije</th>
        </tr>
        <?php foreach($kategorije as $k): $id=$k["id"]; ?>
        <tr>
            <td><?= $k["id"]; ?></td>
            <td><?= $k["naziv"]; ?></td>
            <td>
                <a href="adminkategorija.php?id=<?= $id ?>" class="action-btn">Uredi</a>
                <a href="DeleteKategorija.php?id=<?= $id ?>" class="action-btn delete" onclick="return confirm('Da li želite sigurno obrisati kategoriju <?= $k['naziv'] ?> ?');">Briši</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <p><a href="adminkategorija.php" class="nova">Dodaj novu kategoriju</a></p>
</div>
<?php
require_once "../footer.php";
?>