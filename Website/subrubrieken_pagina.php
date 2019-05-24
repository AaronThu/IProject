<?php
include_once "includes/database.php";
include_once "includes/functies.php";
include_once "includes/header.php";
include_once "includes/databaseFunctions.php";
$rubiekID = 0;
$page = 1;
if (!isset($_GET["rubriekID"])) {
    return;
}
$rubiekID = test_invoer($_GET["rubriekID"]);
if (!is_numeric($rubiekID)) {
    return;
}

if (isset($_GET["page"])) {
    $page = test_invoer($_GET["page"]);
    if (!is_numeric($page)) {
        return;
    }
    $page = max(1, $page);
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
        <div class="pageNumber">
        <form action="" method="get">
            <input type="number" name="rubriekID" value="<?php echo ($rubiekID); ?>"hidden>
            <input type="button" onclick="CountPage(-1)" value="<">
            <input type="number" onChange="this.form.submit()" name="page" id="pageNumber" value = "<?php echo ($page) ?>"min="1">
            <input type="button" onclick="CountPage(1)" value=">">
        </form>
    </div>
        <?php foreach (GetVoorwerpen($rubiekID) as $key => $value) {?>
        <div class="container voorwerp">
            <div class="row">
                <div class="col-md-4">
                    <a href="voorwerppagina.php?voorwerpID=<?php echo $value['Voorwerpnummer']; ?>"><img style="background-image: url(&quot;http://iproject2.icasites.nl/pics/<?php echo $value['FileNaam']; ?>&quot;);width: 250px;height: 166px; background-size: cover; margin-left: -0.5em; margin-top: 0.5em;">
                    </a>
                </div>
                <div class="col-md-5">
                    <p><?php echo $value['Titel']; ?></p>
                    <p style="color: #ffffff;"><?php echo strip_tags(substr($value['Beschrijving'], 0, 100)); ?>  </p>
                </div>
                <div class="col-md-3">
                    <h3 style="color: #ffffff;width: 111px;"><?php echo "€" . $value['Startprijs']; ?>&nbsp;</h3>
                    <p style="color: #ffffff;height: 40px;">U hebt nog (tijd) Om mee te bieden!</p>
                    <a class="btn btn-light d-xl-flex justify-content-end align-items-end align-content-end align-self-end flex-wrap mr-auto justify-content-xl-center align-items-xl-center" role="button" style="background-color: #a9976a;padding: 5px;height: auto;width: Auto;margin: 0px;color: #ffffff;" href="http://iproject2.icasites.nl/voorwerppagina.php?voorwerpID=<?php echo $value['Voorwerpnummer']; ?>">Bied nu mee!</a>
                        <p><?php echo $value['Verzendinstructies']; ?></p>
                </div>
            </div>
        </div>
        <?php }?>
        <div class="pageNumber">
        <form action="" method="get">
            <input type="number" name="rubriekID" value="<?php echo ($rubiekID); ?>"hidden>
            <input type="button" onclick="CountPage(-1)" value="<">
            <input type="number" onChange="this.form.submit()" name="page" id="pageNumber" value = "<?php echo ($page) ?>">
            <input type="button" onclick="CountPage(1)" value=">">
        </form>
    </div>

    </div>
    </div>

    </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/timer.js"></script>
    <script src="assets/js/pagenation.js"></script>
<?php
include_once "includes/footer.php";?>