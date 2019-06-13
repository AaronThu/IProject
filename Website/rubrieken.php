<?php
include_once "includes/database.php";
include_once "includes/header.php";
include_once "includes/functies.php";
?>

<div class="background">
<div class="Main">

<!-- Laat alle rubrieken + subrubrieken zien -->
<?php
foreach (GetRubrieken(-1) as $key => $value) {
    print("<div class=\"container rubriek\">");
    print("<h2 class=\"item\" style=\"width: 10em;\">$value[Rubrieknaam]</h2>");
    print("<div class=\"item background image\" style=\"background-image: url(" . GetRubriekenFoto($value["Rubrieknummer"]) . ")\"></div>");
    print("<div class=\"item\">");
    foreach (GetRubrieken($value["Rubrieknummer"]) as $key => $value) {
        print("<a href=\"/subrubrieken_pagina.php?rubriekID=$value[Rubrieknummer]\">$value[Rubrieknaam]</a>");
    }
    print("</div>");
    print("</div>");
}
?>
</div>
    <script src="assets/js/jquery.min.js"> </script>
    <script src="assets/bootstrap/js/bootstrap.min.js">
    </script>
    </div>
</body>
<?php
include_once "includes/footer.php";
?>