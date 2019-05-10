<?php
session_Start();
include_once("functies.php");
include_once("database.php");
$vraagNummer = genereerVraagNummer($dbh);
$locatieRegistratiesysteem = "Location: http://localhost/EenmaalAndermaal/registratie_systeem.php";
$maximumlengteGegevens = 50;
$foutmeldingen = array("AchternaamErr" => "", "VoornaamErr" => "", "EmailErr" => "", "Adres1Err" => "", "PostcodeErr" => "", "PlaatsnaamErr" => "", "LandErr" => "", "GeboorteDatumErr" => "", "TelefoonErr" => "", "GebruikersNaamErr" => "", "wachtwoord1Err" => "", "wachtwoord2Err" => "", "AntwoordErr" => "");
$_SESSION['registratieFoutmeldingen'] = $foutmeldingen;
$GebruikersnaamTelling = 0;
$wachtwoordMinimaalAantalTekens = 3;
$registratieGegevens = array("Emailadres" => "", "Voornaam" => "", "Achternaam" => "", "Adres_1" => "", "Adres_2" => "", "Postcode" => "", "Plaatsnaam" => "", "Land" => "", "Geboortedatum" => "", "Telefoonnummer" => "", "Gebruikersnaam" => "", "Wachtwoord" => "", "vraagNummer" => "", "AntwoordOpVraag" => "");
$_SESSION['registratieGegevens'] = $registratieGegevens;

if (isset($_POST['registreer'])) {

    $Voornaam = test_invoer($_POST['Voornaam']);
    testInputVoorFouten("Voornaam", "VoornaamErr", $Voornaam);

    $Achternaam = test_invoer($_POST['Achternaam']);
    testInputVoorFouten("Achternaam", "AchternaamErr", $Achternaam);

    if (empty($_POST['Adres_1'])) {
        $_SESSION['registratieFoutmeldingen']['Adres1Err'] = "Minimaal 1 adres moet worden opgegeven";
    } else {
        $_SESSION['registratieGegevens']["Adres_1"] = test_invoer($_POST['Adres_1']);
        if (test_invoer($_POST['Adres_2'])) {
            $_SESSION['registratieGegevens']["Adres_2"] = test_invoer($_POST['Adres_2']);
        }
    }

    $Postcode = test_invoer($_POST['Postcode']);
    testInputVoorFouten("Postcode", "PostcodeErr", $Postcode);

   $Plaatsnaam = test_invoer($_POST['Plaatsnaam']);
   testInputVoorFouten("Plaatsnaam", "PlaatsnaamErr", $Plaatsnaam);

   $Land = test_invoer($_POST['Land']);
   testInputVoorFouten("Land", "LandErr", $Land);


    if (empty($_POST['Telefoonnummer'])) {
        $_SESSION['registratieFoutmeldingen']['TelefoonErr'] = "Telefoonnummer is verplicht";
    } else {
        $_SESSION['registratieGegevens']["Telefoonnummer"] = test_invoer($_POST['Telefoonnummer']);
    }

    if (empty($_POST['GeboorteDatum'])) {
        $_SESSION['registratieFoutmeldingen']['GeboorteDatumErr'] = "Geboortedatum is verplicht";
    } else {
        $_SESSION['registratieGegevens']["Geboortedatum"] = date("m-d-Y", strtotime($_POST['GeboorteDatum']));
    }

    $Gebruikersnaam = test_invoer($_POST['Gebruikersnaam']);
    $Tellinggebruikersnaam = vergelijkloginwaarde("Gebruikersnaam", $Gebruikersnaam, $dbh);
    if (empty($_POST['Gebruikersnaam'])) {
        $_SESSION['registratieFoutmeldingen']['GebruikersNaamErr'] = "Gebruikersnaam is verplicht";
    } elseif ($Tellinggebruikersnaam) {
        $_SESSION['registratieFoutmeldingen']['GebruikersNaamErr'] = "Deze gebruikersnaam is al in gebruik, kies een andere gebruikersnaam";
    } else {
        $_SESSION['registratieGegevens']["Gebruikersnaam"] = $Gebruikersnaam;
    }

    $wachtwoord = test_invoer($_POST['Wachtwoord']);
    $herhaalWachtwoord = test_invoer($_POST['Herhaalwachtwoord']);
    if (empty($wachtwoord) || strlen($wachtwoord) < $wachtwoordMinimaalAantalTekens || kijkVoorLetters($wachtwoord) == false || kijkVoorCijfers($wachtwoord) == false) {
        $_SESSION['registratieFoutmeldingen']['wachtwoord1Err'] = "Kies een wachtwoord met minimaal " . $wachtwoordMinimaalAantalTekens . " karakters, met minimaal 1 letter en 1 cijfer";
    } elseif (empty($herhaalWachtwoord) || $herhaalWachtwoord != $wachtwoord) {
        $_SESSION['registratieFoutmeldingen']['wachtwoord2Err'] = "De twee wachtwoorden komen niet overeen";
    } else {
        $_SESSION['registratieGegevens']["Wachtwoord"] = $wachtwoord;
    }

    if (empty($_POST['AntwoordOpVraag'])) {
        $_SESSION['registratieFoutmeldingen']["AntwoordErr"] = "Vul een antwoord in op de vraag";
    } else {
        $_SESSION['registratieGegevens']["AntwoordOpVraag"] = test_invoer($_POST["AntwoordOpVraag"]);
        $_SESSION['registratieGegevens']["vraagNummer"] = $vraagNummer;
    }

    $EmptyTestArray = array_filter($_SESSION['registratieFoutmeldingen']);
    if (empty($EmptyTestArray)) {
        header("$locatieRegistratiesysteem");
    }
}


include_once("header.php");
?>
    <body class="background">
    <main style="min-height: 52.5vh;margin-right: 10vw;margin-left: 10vw;">
        <div class="container text-center">
            <h2 style="margin: 1ex;color: rgb(255,255,255);">Registreren</h2>
            <form class="text-left" style="width: 100%;" method="post" action="registreren_pagina.php">
                <?php echo registratieFormulierItem("Voornaam", "VoornaamErr", 50, "text", "Voornaam") ;

                 echo registratieFormulierItem("Achternaam", "AchternaamErr", 50, "text", "Achternaam") ;
                echo registratieFormulierItem("Geboortedatum", "GeboorteDatumErr", 50, "date", "GeboorteDatum");

                 echo registratieFormulierItem("Telefoonnummer", "TelefoonErr", 15, "number", "Telefoonnummer");

                 echo registratieFormulierItem("Adresregel 1", "Adres1Err", 50, "text", "Adres_1");

                 echo registratieFormulierItem("Adresregel 2", "Adres1Err", 50, "text", "Adres_2");

                 echo registratieFormulierItem("Postcode", "PostcodeErr", 15, "text", "Postcode");

                 echo registratieFormulierItem("Plaats", "PlaatsnaamErr", 50, "text", "Plaatsnaam");

                echo registratieFormulierItem("Land", "LandErr", 50, "text", "Land");

               $vraag = genereerVraag($dbh, $vraagNummer);
                echo registratieFormulierItem("$vraag", "AntwoordErr", 50, "text", "AntwoordOpVraag");

                 echo registratieFormulierItem("Gebruikersnaam", "GebruikersNaamErr", 50, "text", "Gebruikersnaam");

                  echo registratieFormulierItem("Wachtwoord", "wachtwoord1Err", 50, "password", "Wachtwoord");

                echo registratieFormulierItem("Herhaal wachtwoord", "wachtwoord2Err", 50, "password", "Herhaalwachtwoord") ?>


        <button class="btn btn-primary text-center" data-bs-hover-animate="pulse" type="submit" name="registreer"
                style="width: 100%;margin: 1em 0em;margin-top: 2em;background-color: #ffb357;">Registreer
        </button>
        </form>
        </div>
    </main>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-animation.js"></script>
    </body>
<?php include_once("footer.php"); ?>