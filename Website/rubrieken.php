<?php
include_once "includes/database.php";
include_once "includes/header.php";
include_once "includes/databaseFunctions.php";

// $categorieArtikel = '<div class="container" >';

// $hoofdcategorieData = $dbh->query("SELECT Rubrieknaam, Rubrieknummer FROM Rubriek WHERE Parent_Rubriek = -1 ORDER BY Volgnr, Rubrieknaam");

// $categorieArtikel = ' <div class="container" style="background-color: #4b4c4d;">';
// while ($rij = $hoofdcategorieData->fetch()) {
//     $hoofdcategorie = $rij['Rubrieknaam'];
//     $Rubrieknummer = $rij['Rubrieknummer'];

//     $hoofdcategorieFoto = $dbh->prepare("SELECT RubriekFoto FROM RubriekFotos WHERE Rubrieknummer = :Rubrieknummer");
//     $hoofdcategorieFoto->execute([
//         ':Rubrieknummer' => $Rubrieknummer
//     ]);
//     $foto = $hoofdcategorieFoto->fetchColumn();

//     $categorieArtikel .= '<div class="row text-capitalize text-left" style="">';
//     $categorieArtikel .= '<div class="col-4 col-lg-3" style="color: rgb(255,255,255);background-color: #3a3a3a;">
//                 <a href="#" style="color: #ffffff;">
//                     <h1 style="color: #ffffff; word-wrap:break-word;">' . $rij['Rubrieknaam'] . '</h1>
//                 </a>
//             </div>
//             <div class="col-2 col-lg-3 d-table-cell row">
//                 <img src="assets/img/Rubrieken/' . $foto .'" alt="' . $foto . '" height="250" width="250">
//             </div> <div class="col" style="background-color: #3a3a3a;">';

//     $subcategorie = $dbh->prepare('SELECT Rubrieknaam FROM Rubriek WHERE Parent_Rubriek = :Rubrieknummer ORDER BY Volgnr, Rubrieknaam ');
//     $subcategorie->execute(['Rubrieknummer' => $rij["Rubrieknummer"]]);

//     while ($rij = $subcategorie->fetch()) {
//         $subcategorienaam = $rij['Rubrieknaam'];

//         $categorieArtikel .= '<div class="row col" style="margin-bottom: 5px;"> <a href="?Categorie=' . $subcategorienaam . '" style="color: #ffffff;">
//                         <h6>' . $subcategorienaam . '</h6>
//                     </a> </div>';
//     }
//     $categorieArtikel .= ' </div>';
//     $categorieArtikel .= ' </div>';
// }

// $categorieArtikel .= '</div>';

?>
    <html>

    <body class="background">
        <div class="Main">
    <?php
foreach (GetRubrieken(-1) as $key => $value) {
    print("<div class=\"container rubriek\">");
    print("<h2 class=\"item\" style=\"width: 10em;\">$value[Rubrieknaam]</h2>");
    print("<div class=\"item background image\"><img src=\"" . GetRubriekenFoto($value["Rubrieknummer"]) . "\"></div>");
    print("<div class=\"item\">");
    foreach (GetRubrieken($value["Rubrieknummer"]) as $key => $value) {
        print("<a href=\"/subrubrieken_pagina.php?rubriekID=$value[Rubrieknummer]\">$value[Rubrieknaam]</a>");
    }
    print("</div>");
    print("</div>");
}
?>
</div>
    <script src=" assets/js/jquery.min.js"> </script>
    <script src="assets/bootstrap/js/bootstrap.min.js">
    </script>
    </body>

    </html>

<?php include_once "includes/footer.php";?>