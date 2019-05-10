<?php
include_once("database.php");
include_once("header.php");
$categorieArtikel = '<div class="container" >';


$hoofdcategorieData = $dbh->query("SELECT Rubrieknaam, Rubrieknummer FROM Rubriek WHERE Parent_Rubriek = -1 ORDER BY Volgnr, Rubrieknaam");
while ($rij = $hoofdcategorieData->fetch()) {
    $hoofdcategorie = $rij['Rubrieknaam'];
    $categorieArtikel .= '<div class="row text-capitalize text-left" style="height: 275px;">
        <div class="col-4 col-lg-3 ">
            <a href="#" style="color: #ffffff;">
                <h1 style="color: #ffffff;">' . $rij["Rubrieknaam"] . '</h1>
            </a>
        </div>
        <div class="col-2 col-lg-3 d-table-cell">
            <div class="row" style="background-image: url("assets/img/band.jpg");height: 80%;background-position: center;background-size: cover;background-repeat: no-repeat;">
                <div class="col">
                </div>
            </div>
            <div class="row" style="height: 20%;">
                <div class="col" style="background-color: #3a3a3a;">
                    <header></header>
                </div>
            </div>
        </div>';

    $subcategorie = $dbh->query('SELECT Rubrieknaam FROM Rubriek WHERE Parent_Rubriek =' . $rij["Rubrieknummer"] . 'ORDER BY Volgnr, Rubrieknaam ');
    $categorieArtikel .= ' <div class="row">
                <div class="col" style="color: #ffffff;">';
    while ($rij = $subcategorie->fetch()) {
        $subcategorenaam = $rij['Rubrieknaam'];
        $categorieArtikel .= '<a href="#" style="color: #ffffff;">
                        <h6>' . $subcategorenaam . '</h6>
                    </a>';

    }
    $categorieArtikel .= ' </div>';
    $categorieArtikel .= ' </div>';
}

$categorieArtikel .= '</div>';


?>
<html>
<body class="background"
">
<?php echo $categorieArtikel ?>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>

<?php include_once("footer.php"); ?>


