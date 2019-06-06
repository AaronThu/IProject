<?php
include_once "includes/database.php";
include_once "includes/functies.php";
if (!isset($_SESSION['Gebruikersnaam']) || $_SESSION['Gebruikersnaam'] === "") {
    header("Location: login_pagina.php");
    return;
}
include_once "includes/databaseFunctions.php";
$page = "";
if (!isset($_GET["CurrentPage"])) {
    $page = "Home";
} else {
    $page = $_GET["CurrentPage"];
}
$notifID = null;
if (isset($_GET["NotificatieID"])) {
    if(is_numeric($_GET["NotificatieID"]) && is_numeric($_GET["vwNummer"])){
        $notifID = $_GET["NotificatieID"];
        VerwijderNotificaties($_SESSION['GebruikersID'],$notifID);
        header("Location: voorwerppagina.php?voorwerpID=$_GET[vwNummer]");
        return;
    }
}
include_once "includes/header.php";

$biedGeschiedenis = GetBiedingen($_SESSION['GebruikersID'], 'old');
$mijnVoorwerpen = GetMeerVanVerkoper($_SESSION['GebruikersID'],false);
$currentBiedingen = GetBiedingen($_SESSION['GebruikersID'], 'new');
$notifications = GetNotificaties($_SESSION['GebruikersID'],$_SESSION['SoortGebruiker'],"gegevens");
?>
<div class="Main">
    <div class="content title">
        <h5>Welkom <?php echo ($_SESSION["Gebruikersnaam"]); ?></h5>
    </div>
    <?php if (GetNotificaties($_SESSION['GebruikersID'],$_SESSION['SoortGebruiker'],"telling") > 0) { ?>
        <div class=" content">
            <h5 class="titel">Meldingen</h5>
            <div class="meldingen">
                <?php 
                // genereerMeldingkaart("?NotificatieID=5&vwNummer=110611747579",110611747579,"voorwerpVerkocht","Bericht","Voorwerp titel");
                    foreach ($notifications as $k => $v) {
                        foreach ($v as $key => $value) {
                        $voorwerp = GetVoorwerpEigenschappen($value['Voorwerpnummer']);
                        genereerMeldingkaart(
                            "?NotificatieID=$value[NotificatieID]&vwNummer=$value[Voorwerpnummer]",
                            $value['Voorwerpnummer'],
                            $value['NotificatieSoort'],
                            "",
                            $voorwerp['Titel']
                    );
                        }
                    }
                ?>
            </div>
        </div>
    <?php } ?>
    <div class="content">
        <div class="tabs">
            <!-- highlight -->
            <a href="?CurrentPage=Home" class="tabButton <?php echo ($page === "Home" ? "highlight" : "") ?>">Biedingen</a>
            <a href="?CurrentPage=Settings" class="tabButton <?php echo ($page === "Settings" ? "highlight" : "") ?>">Gegevens</a>
        </div>
        <!-- START HOME -->
        <div class="Home <?php echo ($page === "Home" ? "" : "noShow") ?>">
            <h5 class="titel">Mijn Biedingen</h5>
            <div class="row d-flex flex-wrap">
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
                        echo ("<div class=\"row d-flex flex-wrap item head\">");
                        echo ("<h5 class=\"col-md-3\">Titel</h5>");
                        echo ("<h5 class=\"col-md-3\">Eindmoment</h5>");
                        echo ("<h5 class=\"col-md-3\">Startprijs</h5>");
                        echo ("<h5 class=\"col-md-3\">Verkoopprijs</h5>");
                        echo ("</div>");
                        foreach ($mijnVoorwerpen as $key => $value) {
                            echo ("<a href=\"voorwerppagina.php?voorwerpID=$value[Voorwerpnummer]\" class=\"row d-flex flex-wrap item\">");
                            echo ("<h5 class=\"col-md-3\">[Titel]</h5>");
                            echo ("<h5 class=\"col-md-3\">[Eindmoment]</h5>");
                            echo ("<h5 class=\"col-md-3\">[Startprijs]</h5>");
                            echo ("<h5 class=\"col-md-3\">[Verkoopprijs]</h5>");
                            echo ("</a>");
                        }
                    } else { ?>
                        <h5 class="noResults">U bied geen voorwerpen aan</h5>
                    <?php } ?>
                </div>
            <?php } ?>
            <h5 class="titel">Mijn Biedgeschiedenis</h5>
            <div class="row d-flex flex-wrap voorwerpLijst">
                <?php
                if (sizeof($biedGeschiedenis) > 0) {
                    echo ("<div class=\"row d-flex flex-wrap item head\">");
                    echo ("<h5 class=\"col-md-3\">Titel</h5>");
                    echo ("<h5 class=\"col-md-3\">Eindmoment</h5>");
                    echo ("<h5 class=\"col-md-3\">Startprijs</h5>");
                    echo ("<h5 class=\"col-md-3\">Verkoopprijs</h5>");
                    echo ("</div>");
                    foreach ($biedGeschiedenis as $key => $value) {
                        echo ("<a href=\"voorwerppagina.php?voorwerpID=$value[Voorwerpnummer]\" class=\"row d-flex flex-wrap item\">");
                        echo ("<h5 class=\"col-md-3\">$value[Titel]</h5>");
                        echo ("<h5 class=\"col-md-3\">$value[Eindmoment]</h5>");
                        echo ("<h5 class=\"col-md-3\">$value[Startprijs]</h5>");
                        echo ("<h5 class=\"col-md-3\">$value[Verkoopprijs]</h5>");
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
            <div>
                <div class="item">
                    <h6>Gebruikersnaam:</h6>
                    <p><?php echo ($_SESSION['Gebruikersnaam']); ?></p>
                </div>
                <div class="item">
                    <h6>Emailadres:</h6>
                    <p><?php echo ($_SESSION['Emailadres']); ?></p>
                </div>
                <div class="item">
                    <h6>Voornaam:</h6>
                    <p><?php echo ($_SESSION['Voornaam']); ?></p>
                </div>
                <div class="item">
                    <h6>Achternaam:</h6>
                    <p><?php echo ($_SESSION['Achternaam']); ?></p>
                </div>
                <div class="item">
                    <h6>Adres 1:</h6>
                    <p><?php echo ($_SESSION['Adres_1']); ?></p>
                </div>
                <div class="item">
                    <h6>Adres 2:</h6>
                    <p><?php echo ($_SESSION['Adres_2'] === "" ? "Niet opgegeven" : $_SESSION['Adres_2']); ?></p>
                </div>
                <div class="item">
                    <h6>Postcode:</h6>
                    <p><?php echo ($_SESSION['Postcode']); ?></p>
                </div>
                <div class="item">
                    <h6>Plaatsnaam:</h6>
                    <p><?php echo ($_SESSION['Plaatsnaam']); ?></p>
                </div>
                <div class="item">
                    <h6>Land:</h6>
                    <p><?php echo ($_SESSION['Land']); ?></p>
                </div>
                <div class="item">
                    <h6>Geboortedatum:</h6>
                    <p><?php echo ($_SESSION['GeboorteDatum']); ?></p>
                </div>
                <div class="item">
                    <h6>Type Account:</h6>
                    <p><?php echo (ucfirst($_SESSION['SoortGebruiker'])); ?></p>
                </div>
            </div>

            <?php
            if ($_SESSION['SoortGebruiker'] === 'koper' || (isset($_SESSION['VerkoperStatus']) && $_SESSION['VerkoperStatus'] == 'aanvraging')) {
                echo ('<div class="registreerVerkoopKnop">');
                if ($_SESSION['SoortGebruiker'] === 'koper') {
                    echo ('<a href="registreren_verkoper.php">Registreer als verkoper</a>');
                } else {
                    echo ('<a href="registratie_verkopers_code.php">Registratiecode invullen</a>');
                }
                echo ('</div>');
            }
            ?>
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