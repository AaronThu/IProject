<?php
include_once "includes/database.php";
include_once "includes/functies.php";
include_once "includes/header.php";
$rubiekID = 0;
if (!isset($_GET["rubriekID"])) {
    return;
}
$rubiekID = test_invoer($_GET["rubriekID"]);
if (!is_numeric($rubiekID)) {
    return;
}
?>
    <div class="Main">
    <ul class="breadcrum">
        <?php
$ID = $rubiekID;
while ($ID > 0) {
    $Rub = GetParentRubrieken($ID);
    $ID = $Rub["Parent_Rubriek"];
    if ($Rub["Rubrieknummer"] == $rubiekID) {
        print("<li><a class=\"highlight\">$Rub[Rubrieknaam]</a></li>");
    } else {
        print("<li><a href=\"/subrubrieken_pagina.php?rubriekID=$Rub[Rubrieknummer]\">$Rub[Rubrieknaam]</a></li>");
    }
}
?>
 <li><a href="index.php">Home</a></li>
    </ul>

    <div class="lijst">
        <div class=" subrubriekenlijst">
<?php
$alleRubrieken = GetRubrieken(GetParentRubrieken($rubiekID)["Parent_Rubriek"]);
foreach ($alleRubrieken as $key => $value) {
    print("<div class=\"categorieDropdown\">");
    if ($value["Rubrieknummer"] == $rubiekID) {
        print(" <a class=\"highlight\">$value[Rubrieknaam]</a>");
        $subRubrieken = GetRubrieken($value["Rubrieknummer"]);
        if ($value["Rubrieknummer"] == $rubiekID && sizeof($subRubrieken) > 0) {
            print("<div class=\"dropper\">");
            foreach ($subRubrieken as $key => $value) {
                print("<div><a href=\"/subrubrieken_pagina.php?rubriekID=$value[Rubrieknummer]\">$value[Rubrieknaam]</a></div>");
            }
            print("</div>");
        }
    }
    print("</div>");
}
foreach ($alleRubrieken as $key => $value) {
    print("<div class=\"categorieDropdown\">");
    if ($value["Rubrieknummer"] != $rubiekID) {
        print(" <a href=\"/subrubrieken_pagina.php?rubriekID=$value[Rubrieknummer]\">$value[Rubrieknaam]</a>");
    }
    print("</div>");
}
?>
        </div>
        <div class=" voorwerplijst">

        </div>
    </div>


    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/timer.js"></script>
<?php
include_once "includes/footer.php";?>