<?php
include_once "includes/database.php";
include_once "includes/functies.php";
if (!isset($_SESSION['Gebruikersnaam']) || $_SESSION['Gebruikersnaam'] === "") {
    header("Location: login_pagina.php");
    return;
}
include_once "includes/header.php";
include_once "includes/databaseFunctions.php";
$page = "";
if (!isset($_GET["CurrentPage"])) {
    $page = "Home";
} else {
    $page = $_GET["CurrentPage"];
}
$biedGeschiedenis = GetBiedingen($_SESSION['GebruikersID'], 'old');
$mijnVoorwerpen = [];
$currentBiedingen = GetBiedingen($_SESSION['GebruikersID'], 'new');;
?>
<div class="Main">
    <div class="content title">
        <h5>Welkom <?php echo ($_SESSION["Gebruikersnaam"]); ?></h5>
    </div>
    <?php if (true) { ?>
        <div class="content meldingen">
            <h5>hier komen alle meldingen</h5>
        </div>
    <?php } ?>
    <div class="content">
        <div class="tabs">
            <!-- highlight -->
            <a href="?CurrentPage=Home" class="tabButton <?php echo ($page === "Home" ? "highlight" : "") ?>">Home</a>
            <a href="?CurrentPage=Settings" class="tabButton <?php echo ($page === "Settings" ? "highlight" : "") ?>">Settings</a>
        </div>
        <!-- START HOME -->
        <div class="Home <?php echo ($page === "Home" ? "" : "noShow") ?>">
            <h5 class="titel">Mijn Biedingen</h5>
            <div class="row d-flex flex-wrap ">
                <?php
                if (sizeof($currentBiedingen) > 0) {
                    foreach ($currentBiedingen as $key => $value) {
                        genereerArtikel(
                            $value['Titel'],
                            $value['Eindmoment'],
                            $value['Startprijs'],
                            $value['Startprijs'],
                            $value['Voorwerpnummer'],
                            "col-md-2"
                        );
                    }
                } else { ?>
                    <h5 class="noResults">Geen huidige biedingen</h5>
                <?php } ?>
            </div>
            <?php if ((isset($_SESSION["SoortGebruiker"]) && $_SESSION["SoortGebruiker"] !== "koper")) { ?>
                <h5 class="titel">Mijn Voorwerpen</h5>
                <div class="row d-flex flex-wrap ">
                    <?php
                    if (sizeof($mijnVoorwerpen) > 0) {
                        foreach ($mijnVoorwerpen as $key => $value) {
                            genereerArtikel(
                                $value['Titel'],
                                $value['Eindmoment'],
                                $value['Startprijs'],
                                $value['Startprijs'],
                                $value['Voorwerpnummer'],
                                "col-md-2"
                            );
                        }
                    } else { ?>
                        <h5 class="noResults">U bied geen voorwerpen aan</h5>
                    <?php } ?>
                </div>
            <?php } ?>
            <h5 class="titel">Mijn Bied Geschiedenis</h5>
            <div class="column d-flex flex-wrap voorwerpLijst">
                <?php
                if (sizeof($biedGeschiedenis) > 0) {
                    foreach ($biedGeschiedenis as $key => $value) {
                        echo ("<a href=\"\" class=\"item\">");
                        echo ("<h5>$value[Titel]</h5>");
                        echo ("<h5>$value[Eindmoment]</h5>");
                        echo ("<h5>$value[Startprijs]</h5>");
                        echo ("<h5>$value[Startprijs]</h5>");
                        echo ("<h5>$value[Voorwerpnummer]</h5>");
                        echo ("</a>");
                    }
                } else { ?>
                    <h5 class="noResults">Geen biedgeschiedenis</h5>
                <?php } ?>
            </div>
        </div>
        <!-- END HOME -->
        <!-- START SETTINGS -->
        <div class="Settings <?php echo ($page === "Settings" ? "" : "noShow") ?>">
            <form class="settings-form" action="" method="post">
                <div class="item"><label>Name</label><input required class="form-control inputforms" type="text" name="Name" id="" value="<?php echo (isset($_POST["Name"]) ? ($_POST["Name"]) : "") ?>"></div>
                <div class="item"><label>Name</label><input required class="form-control inputforms" type="text" name="Name" id="" value="<?php echo (isset($_POST["Name"]) ? ($_POST["Name"]) : "") ?>"></div>
                <div class="item"><label>Name</label><input required class="form-control inputforms" type="text" name="Name" id="" value="<?php echo (isset($_POST["Name"]) ? ($_POST["Name"]) : "") ?>"></div>
                <div class="item"><label>Name</label><input required class="form-control inputforms" type="text" name="Name" id="" value="<?php echo (isset($_POST["Name"]) ? ($_POST["Name"]) : "") ?>"></div>
                <div class="item"><label>Name</label><input required class="form-control inputforms" type="text" name="Name" id="" value="<?php echo (isset($_POST["Name"]) ? ($_POST["Name"]) : "") ?>"></div>
                <div class="item"><label>Name</label><input required class="form-control inputforms" type="text" name="Name" id="" value="<?php echo (isset($_POST["Name"]) ? ($_POST["Name"]) : "") ?>"></div>
                <div class="item"><label>Name</label><input required class="form-control inputforms" type="text" name="Name" id="" value="<?php echo (isset($_POST["Name"]) ? ($_POST["Name"]) : "") ?>"></div>
                <div class="item"><label>Name</label><input required class="form-control inputforms" type="text" name="Name" id="" value="<?php echo (isset($_POST["Name"]) ? ($_POST["Name"]) : "") ?>"></div>
                <div class="item"><label>Name</label><input required class="form-control inputforms" type="text" name="Name" id="" value="<?php echo (isset($_POST["Name"]) ? ($_POST["Name"]) : "") ?>"></div>
                <div class="item"><label>Name</label><input required class="form-control inputforms" type="text" name="Name" id="" value="<?php echo (isset($_POST["Name"]) ? ($_POST["Name"]) : "") ?>"></div>
                <div class="item"><label>Name</label><input required class="form-control inputforms" type="text" name="Name" id="" value="<?php echo (isset($_POST["Name"]) ? ($_POST["Name"]) : "") ?>"></div>
                <div class="item"><label>Name</label><input required class="form-control inputforms" type="text" name="Name" id="" value="<?php echo (isset($_POST["Name"]) ? ($_POST["Name"]) : "") ?>"></div>
                <div class="item"><button type="submit">Wijzig</button></div>
            </form>
        </div>
        <!-- END SETTINGS -->
    </div>
</div>
<script src="assets/js/utils.js"></script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/timer.js"></script>
<?php
include_once "includes/footer.php"; ?>