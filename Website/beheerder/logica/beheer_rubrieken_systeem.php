<?php
include_once '../includes/functies.php';
include_once 'databaseFuncties.php';
include_once "../includes/database.php";

$sortNummer = false;
$sortName = false;
$sortParentRubriek = false;
$sortAflopend = false;
$ZoekOpNaam = true;
$ZoekOpParent = false;

$zoekKeys = "";
$results = [];

if (isset($_POST["InsertRubriek"]) && isset($_SESSION["Gebruikersnaam"])) {
    InsertRubriek(
        $_SESSION["Gebruikersnaam"],
        test_invoer($_POST["RubriekName"]),
        test_invoer($_POST["RubriekParent"]),
        test_invoer($_POST["RubriekVolgNummer"]),
        isset($_POST["Accept"]) ? true : false
    );
}

if (isset($_POST["UpdateRubriek"]) && isset($_SESSION["Gebruikersnaam"])) {
    UpdateRubriek(
        $_SESSION["Gebruikersnaam"],
        test_invoer($_POST["RubriekID"]),
        test_invoer($_POST["RubriekName"]),
        test_invoer($_POST["RubriekParent"]),
        test_invoer($_POST["RubriekVolgNummer"]),
        isset($_POST["Accept"]) ? true : false
    );
}

if (isset($_POST["DeleteRubriek"]) && isset($_SESSION["Gebruikersnaam"])) {
    DeleteRubriek(
        $_SESSION["Gebruikersnaam"],
        test_invoer($_POST["RubriekID"]),
        isset($_POST["Accept"]) ? true : false
    );
}

if (isset($_POST["HerOpenRubriek"]) && isset($_SESSION["Gebruikersnaam"])) {
    HerOpenRubriek(
        $_SESSION["Gebruikersnaam"],
        test_invoer($_POST["RubriekID"]),
        isset($_POST["Accept"]) ? true : false
    );
}

if (isset($_GET["sortNaamRubriek"])) {
    $sortName = true;
}
if (isset($_GET["sortVolgnummer"])) {
    $sortNummer = true;
}
if (isset($_GET["sortParentRubriek"])) {
    $sortParentRubriek = true;
}

if (isset($_GET["sortAflopend"])) {
    $sortAflopend = true;
}

if (isset($_GET["NaamRubriek"])) {
    $ZoekOpNaam = true;
} else if (isset($_GET["NaamParent"])) {
    $ZoekOpNaam = false;
}

if (isset($_GET["NaamParent"])) {
    $ZoekOpParent = true;
}

if (isset($_GET["SearchBar"])) {
    $zoekKeys = test_invoer($_GET["SearchBar"]);
    $results = ZoekRubrieken($zoekKeys, $sortName, $sortNummer, $sortParentRubriek, $sortAflopend, $ZoekOpNaam, $ZoekOpParent);
}

?>