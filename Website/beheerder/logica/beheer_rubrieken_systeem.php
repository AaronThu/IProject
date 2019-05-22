<?php
include_once '../includes/functies.php';
include_once 'databaseFuncties.php';
include_once "../includes/database.php";

$sortNummer = false;
$sortName = false;
$parentRubriek = false;
if (isset($_GET["Naam"])) {
    $sortName = true;
}
if (isset($_GET["volgnummer"])) {
    $sortNummer = true;
}
if (isset($_GET["parentRubriek"])) {
    $parentRubriek = true;
}
$zoekKeys = "";
$results = [];

if (isset($_GET["SearchBar"]) && $_GET["SearchBar"] !== "") {
    $zoekKeys = test_invoer($_GET["SearchBar"]);
    $results = ZoekRubrieken($zoekKeys, $sortName, $sortNummer, $parentRubriek);
}

if (isset($_POST["InsertRubriek"]) && isset($_SESSION["Gebruikersnaam"])) {
    // InsertRubriek(
    //     $_SESSION["Gebruikersnaam"],
    //     test_invoer($_POST["RubriekName"]),
    //     test_invoer($_POST["RubriekParent"]),
    //     test_invoer($_POST["RubriekVolgNummer"]),
    //     isset($_POST["Accept"]) ? true : false
    // );
}

if (isset($_POST["UpdateRubriek"]) && isset($_SESSION["Gebruikersnaam"])) {
    // UpdateRubriek(
    //     $_SESSION["Gebruikersnaam"],
    //     test_invoer($_POST["RubriekID"]),
    //     test_invoer($_POST["RubriekName"]),
    //     test_invoer($_POST["RubriekParent"]),
    //     test_invoer($_POST["RubriekVolgNummer"]),
    //     isset($_POST["Accept"]) ? true : false
    // );
}

if (isset($_POST["DeleteRubriek"]) && isset($_SESSION["Gebruikersnaam"])) {
    // DeleteRubriek(
    //     $_SESSION["Gebruikersnaam"],
    //     test_invoer($_POST["RubriekID"]),
    //     isset($_POST["Accept"]) ? true : false
    // );
}
?>