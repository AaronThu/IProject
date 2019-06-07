<?php
include_once "includes/database.php";
include_once "includes/functies.php";
include_once "includes/header.php";

$rubiekID = 0;
$maxPage = 1;
$maxOnPage = 20;
$page = 1;
$sortOn = [];
$aflopen = false;
if (!isset($_GET["rubriekID"])) {
    return;
}

if (isset($_GET["SortNaam"]) && $_GET["SortNaam"] === "on") {
    array_push($sortOn, "Titel");
}
if (isset($_GET["SortPrijs"]) && $_GET["SortPrijs"] === "on") {
    array_push($sortOn, "Verkoopprijs, Startprijs");
}
if (isset($_GET["SortTijdResterend"]) && $_GET["SortTijdResterend"] === "on") {
    array_push($sortOn, "Eindmoment");
}
if (isset($_GET["SortAflopend"]) && $_GET["SortAflopend"] === "on") {
    $aflopen = true;
}

$rubiekID = test_invoer($_GET["rubriekID"]);
if (!is_numeric($rubiekID)) {
    return;
}
$maxPage = ceil(GetVoorwerpCount($rubiekID) / $maxOnPage);
if (isset($_GET["page"])) {
    $page = test_invoer($_GET["page"]);
    if (!is_numeric($page)) {
        return;
    }
    $page = max(1, min($page, $maxPage));
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
    <div class="voorwerplijst">
        <?php $voorwerpen = GetVoorwerpen($rubiekID, $sortOn, $aflopen, $page, $maxOnPage);?>
        <?php if (sizeof($voorwerpen) <= 0) {?>
            <h5 style="text-align: center;padding: 5em;height: 25em">Helaas geen voorwerpen beschikbaar</h5>
        <?php
} else {
    include 'includes/pageNavigation.php';
    ?>
     <!-- Sorting box -->
        <div class="sortingContainer">
            <div>
                <div><h5 class="title">Sorteren op:</h5></div>
                <div><input type="checkbox" onChange="this.form.submit()" name="SortNaam" id="SortNaam" form="PageInfo" <?php echo (isset($_GET["SortNaam"]) ? "checked" : "") ?>> <label for="SortNaam">Naam</label></div>
                <div><input type="checkbox" onChange="this.form.submit()" name="SortPrijs" id="SortPrijs" form="PageInfo" <?php echo (isset($_GET["SortPrijs"]) ? "checked" : "") ?>> <label for="SortPrijs">Prijs</label></div>
                <div><input type="checkbox" onChange="this.form.submit()" name="SortTijdResterend" id="SortTijdResterend" form="PageInfo" <?php echo (isset($_GET["SortTijdResterend"]) ? "checked" : "") ?>> <label for="SortTijdResterend">Tijd Resterend</label></div>
                <div><input type="checkbox" onChange="this.form.submit()" name="SortAflopend" id="SortAflopend" form="PageInfo" <?php echo (isset($_GET["SortAflopend"]) ? "checked" : "") ?>> <label for="SortAflopend">Aflopend</label></div>
            </div>
        </div>
        <?php foreach ($voorwerpen as $key => $value) {?>
        <div class="container voorwerp">
            <div class="row">
                <div class="col-md-4">
                    <a href="voorwerppagina.php?voorwerpID=<?php echo $value['Voorwerpnummer']; ?>"><div style="background-image: url(&quot;http://iproject2.icasites.nl/<?php echo $value['FileNaam']; ?>&quot;);width: 250px;height: 166px; background-size: cover; margin-left: -0.5em; margin-top: 0.5em;">
                        </div>
                    </a>
                </div>
                <div class="col-md-5">
                    <p><?php echo $value['Titel']; ?></p>
                    <p style="color: #ffffff;"><?php echo strip_tags(substr($value['Beschrijving'], 0, 100)); ?>  </p>
                </div>
                <div class="col-md-3">
                    <h3 style="color: #ffffff;width: 111px;"><?php echo "€" . $value['Startprijs']; ?>&nbsp;</h3><br><br>
                    <img class = 'clock' src = "assets/img/clock.jpg" alt="klok"><h6 class="Timer" data-time="<?php echo ($value['Eindmoment']); ?>" style="display: inline; color: #ffffff"></h6><br><br><br><br>
                    <a class="btn btn-light d-xl-flex justify-content-end align-items-end align-content-end align-self-end flex-wrap mr-auto justify-content-xl-center align-items-xl-center" role="button" style="background-color: #a9976a;padding: 5px;height: auto;width: Auto;margin: 0px;color: #ffffff;" href="voorwerppagina.php?voorwerpID=<?php echo $value['Voorwerpnummer']; ?>">Bied nu mee!</a>
                </div>
            </div>
        </div>
        <?php }
    include 'includes/pageNavigation.php';
}?>
    </div>
    </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/timer.js"></script>
    <script src="assets/js/pagenation.js"></script>
<?php
include_once "includes/footer.php";?>