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

    <!-- <div style="display:flex;">
        <div class="container subrubriekenlijst">
            <div class="categorieDropdown"><a href="#">Link</a>
                <div class="dropper">
                    <div><a href="#">Link</a></div>
                    <div><a href="#">Link</a></div>
                    <div><a href="#">Link</a></div>
                    <div><a href="#">Link</a></div>
                    <div><a href="#">Link</a></div>
                    <div><a href="#">Link</a></div>
                </div>
            </div>
        </div>
        <div class="container voorwerplijst"></div>
    </div> -->

    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/timer.js"></script>
<?php
include_once "includes/footer.php";?>