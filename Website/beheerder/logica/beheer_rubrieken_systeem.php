<?php
include_once '../../includes/functies.php';
include_once 'databaseFuncties.php';
include_once "../../includes/database.php";

if (!isset($_SESSION['Gebruikersnaam']) || (isset($_SESSION['Gebruikersnaam']) && !IsAdmin($_SESSION['Gebruikersnaam']))) {
    header("Location: ../index.php");
    return;
}

if (isset($_POST["InsertRubriek"]) && isset($_SESSION["Gebruikersnaam"])) {
    InsertRubriek(
        $_SESSION["Gebruikersnaam"],
        test_invoer($_POST["RubriekName"]),
        test_invoer($_POST["RubriekParent"]),
        test_invoer($_POST["RubriekVolgNummer"]),
        test_invoer($_POST["Accept"])
    );
}

if (isset($_POST["UpdateRubriek"]) && isset($_SESSION["Gebruikersnaam"])) {
    UpdateRubriek(
        $_SESSION["Gebruikersnaam"],
        test_invoer($_POST["RubriekID"]),
        test_invoer($_POST["RubriekName"]),
        test_invoer($_POST["RubriekParent"]),
        test_invoer($_POST["RubriekVolgNummer"]),
        $_POST["Accept"]
    );
}

if (isset($_POST["DeleteRubriek"]) && isset($_SESSION["Gebruikersnaam"])) {
    DeleteRubriek(
        $_SESSION["Gebruikersnaam"],
        test_invoer($_POST["RubriekID"]),
        test_invoer($_POST["Accept"])
    );
}
?>