<?php
session_Start();
include_once("functies.php");
include_once("database.php");
$vraagNummer = genereerVraagNummer($dbh);
$locatieRegistratiesysteem = "Location: http://localhost/EenmaalAndermaal/registratie_systeem.php";
$maximumlengteGegevens = 50;
$foutmeldingen = array("AchternaamErr" => "", "VoornaamErr" => "", "EmailErr" => "", "Adres1Err" => "", "PostcodeErr" => "", "PlaatsnaamErr" => "", "LandErr" => "", "GeboorteDatumErr" => "", "TelefoonErr" => "", "GebruikersNaamErr" => "", "wachtwoord1Err" => "", "wachtwoord2Err" => "", "AntwoordErr" => "");
$GebruikersnaamTelling = 0;
$wachtwoordMinimaalAantalTekens = 3;
$registratieGegevens = array("Emailadres" => "", "Voornaam" => "", "Achternaam" => "", "Adres_1" => "", "Adres_2" => "", "Postcode" => "", "Plaatsnaam" => "", "Land" => "", "Geboortedatum" => "", "Telefoonnummer" => "", "Gebruikersnaam" => "", "Wachtwoord" => "", "vraagNummer" => "", "AntwoordOpVraag" => "");

if (isset($_POST['registreer'])) {
    if (empty($_POST['Voornaam'])) {
        $foutmeldingen['VoornaamErr'] = "Voornaam is verplicht";
    } else {
        $registratieGegevens["Voornaam"] = test_invoer($_POST['Voornaam']);
    }

    if (empty($_POST['Achternaam'])) {
        $foutmeldingen['AchternaamErr'] = "Achternaam is verplicht";
    } else {
        $registratieGegevens["Achternaam"] = test_invoer($_POST['Achternaam']);
    }

    if (empty($_POST['Adres_1'])) {
        $foutmeldingen['Adres1Err'] = "Minimaal 1 adres moet worden opgegeven";
    } else {
        $registratieGegevens["Adres_1"] = test_invoer($_POST['Adres_1']);
        if (test_invoer($_POST['Adres_2'])) {
            $registratieGegevens["Adres_2"] = test_invoer($_POST['Adres_2']);
        }
    }

    if (empty($_POST['Postcode'])) {
        $foutmeldingen['PostcodeErr'] = "Postcode is verplicht";
    } else {
        $registratieGegevens["Postcode"] = test_invoer($_POST['Postcode']);
    }

    if (empty($_POST['Plaatsnaam'])) {
        $foutmeldingen['PlaatsnaamErr'] = "Plaatsnaam is verplicht";
    } else {
        $registratieGegevens["Plaatsnaam"] = test_invoer($_POST['Plaatsnaam']);
    }

    if (empty($_POST['Land'])) {
        $foutmeldingen['LandErr'] = "Land is verplicht";
    } else {
        $registratieGegevens["Land"] = test_invoer($_POST['Land']);
    }

    if (empty($_POST['Telefoonnummer'])) {
        $foutmeldingen['TelefoonErr'] = "Telefoonnummer is verplicht";
    } else {
        $registratieGegevens["Telefoonnummer"] = test_invoer($_POST['Telefoonnummer']);
    }

    if (empty($_POST['GeboorteDatum'])) {
        $foutmeldingen['GeboorteDatumErr'] = "Geboortedatum is verplicht";
    } else {
        $registratieGegevens["Geboortedatum"] = date("m-d-Y", strtotime($_POST['GeboorteDatum']));
    }

    $Gebruikersnaam = test_invoer($_POST['Gebruikersnaam']);
    $Tellinggebruikersnaam = vergelijkloginwaarde("Gebruikersnaam", $Gebruikersnaam, $dbh);
    if (empty($_POST['Gebruikersnaam'])) {
        $foutmeldingen['GebruikersNaamErr'] = "Gebruikersnaam is verplicht";
    } elseif ($Tellinggebruikersnaam) {
        $foutmeldingen['GebruikersNaamErr'] = "Deze gebruikersnaam is al in gebruik, kies een andere gebruikersnaam";
    } else {
        $registratieGegevens["Gebruikersnaam"] = $Gebruikersnaam;
    }

    $wachtwoord = test_invoer($_POST['Wachtwoord']);
    $herhaalWachtwoord = test_invoer($_POST['Herhaalwachtwoord']);
    if (empty($wachtwoord) || strlen($wachtwoord) < $wachtwoordMinimaalAantalTekens || kijkVoorLetters($wachtwoord) == false || kijkVoorCijfers($wachtwoord) == false) {
        $foutmeldingen['wachtwoord1Err'] = "Kies een wachtwoord met minimaal " . $wachtwoordMinimaalAantalTekens . " karakters, met minimaal 1 letter en 1 cijfer";
    } elseif (empty($herhaalWachtwoord) || $herhaalWachtwoord != $wachtwoord) {
        $foutmeldingen['wachtwoord2Err'] = "De twee wachtwoorden komen niet overeen";
    } else {
        $registratieGegevens["Wachtwoord"] = $wachtwoord;
    }

    if (empty($_POST['AntwoordOpVraag'])) {
        $foutmeldingen["AntwoordErr"] = "Vul een antwoord in op de vraag";
    } else {
        $registratieGegevens["AntwoordOpVraag"] = test_invoer($_POST["AntwoordOpVraag"]);
        $registratieGegevens["vraagNummer"] = $vraagNummer;
    }

    $EmptyTestArray = array_filter($foutmeldingen);
    if (empty($EmptyTestArray)) {
        $_SESSION['registratieGegevens'] = $registratieGegevens;
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
                <h5 class="text-center text-sm-cewnter text-md-center text-lg-left text-xl-center">Voornaam*</h5>
                <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center foutmeldingTekst"> <?php echo $foutmeldingen['VoornaamErr']; ?></h5>
                <div class="d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-center align-items-center flex-wrap flex-sm-wrap flex-md-nowrap flex-lg-nowrap justify-content-xl-center align-items-xl-center flex-xl-nowrap"
                     style="margin: 1em 0em;"><input
                            class="form-control inputforms" type="text"
                            placeholder="Voornaam" name="Voornaam" autofocus="" maxlength="50"
                            value="<?php echo isset($_POST["Voornaam"]) ? $_POST["Voornaam"] : ''; ?>"></div>
                <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center">Achternaam*</h5>
                <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center foutmeldingTekst"> <?php echo $foutmeldingen['AchternaamErr']; ?></h5>
                <div class="d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-center align-items-center flex-wrap flex-sm-wrap flex-md-nowrap flex-lg-nowrap justify-content-xl-center align-items-xl-center flex-xl-nowrap
                 style=" margin: 1em 0em;
                "><input
                        class="form-control inputforms" type="text"
                        placeholder="Achternaam" name="Achternaam" autofocus="" maxlength="50"
                        value="<?php echo isset($_POST["Achternaam"]) ? $_POST["Achternaam"] : ''; ?>">
        </div>
        <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center">Geboortedatum*</h5>
        <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center foutmeldingTekst"> <?php echo $foutmeldingen['GeboorteDatumErr']; ?></h5>
        <div class="d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-center align-items-center flex-wrap flex-sm-wrap flex-md-nowrap flex-lg-nowrap justify-content-xl-center align-items-xl-center flex-xl-nowrap"
             style="margin: 1em 0em;"><input
                    class="form-control inputforms" type="date" name="GeboorteDatum"
                    value="<?php echo isset($_POST["GeboorteDatum"]) ? $_POST["GeboorteDatum"] : ''; ?>"></div>
        <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center">Adres 1*</h5>
        <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center foutmeldingTekst"> <?php echo $foutmeldingen['Adres1Err']; ?></h5>
        <div class="d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-center align-items-center flex-wrap flex-sm-wrap flex-md-nowrap flex-lg-nowrap justify-content-xl-center align-items-xl-center flex-xl-nowrap"
             style="margin: 1em 0em;"><input class="form-control inputforms" type="text"
                                             placeholder="Adres 1" name="Adres_1" maxlength="50"
                                             value="<?php echo isset($_POST["Adres_1"]) ? $_POST["Adres_1"] : ''; ?>">
        </div>
        <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center">Adres 2</h5>
        <div class="d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-center align-items-center flex-wrap flex-sm-wrap flex-md-nowrap flex-lg-nowrap justify-content-xl-center align-items-xl-center flex-xl-nowrap"
             style="margin: 1em 0em;">
            <input class="form-control inputforms" type="text"
                   placeholder="Adres 2" name="Adres_2" maxlength="15"
                   value="<?php echo isset($_POST["Adres_2"]) ? $_POST["Adres_2"] : ''; ?>">
        </div>

        <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center">Postcode*</h5>
        <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center foutmeldingTekst"> <?php echo $foutmeldingen['PostcodeErr']; ?></h5>
        <div class="d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-center align-items-center flex-wrap flex-sm-wrap flex-md-nowrap flex-lg-nowrap justify-content-xl-center align-items-xl-center flex-xl-nowrap"
             style="margin: 1em 0em;"><input
                    class="form-control inputforms" type="text"
                    placeholder="Postcode" name="Postcode" autofocus="" maxlength="7"
                    value="<?php echo isset($_POST["Postcode"]) ? $_POST["Postcode"] : ''; ?>"></div>

        <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center">Plaats*</h5>
        <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center foutmeldingTekst"> <?php echo $foutmeldingen['PlaatsnaamErr']; ?></h5>
        <div class="d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-center align-items-center flex-wrap flex-sm-wrap flex-md-nowrap flex-lg-nowrap justify-content-xl-center align-items-xl-center flex-xl-nowrap"
             style="margin: 1em 0em;"><input
                    class="form-control inputforms" type="text"
                    placeholder="Plaats" name="Plaatsnaam" autofocus="" maxlength="50"
                    value="<?php echo isset($_POST["Plaatsnaam"]) ? $_POST["Plaatsnaam"] : ''; ?>"></div>
        <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center">Land*</h5>
        <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center foutmeldingTekst"> <?php echo $foutmeldingen['LandErr']; ?></h5>
        <div class="d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-center align-items-center flex-wrap flex-sm-wrap flex-md-nowrap flex-lg-nowrap justify-content-xl-center align-items-xl-center flex-xl-nowrap"
             style="margin: 1em 0em;"><input
                    class="form-control inputforms" type="text"
                    placeholder="Land" name="Land" autofocus="" maxlength="50"
                    value="<?php echo isset($_POST["Land"]) ? $_POST["Land"] : ''; ?>"></div>

        <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center">Telefoonnummer*</h5>
        <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center foutmeldingTekst"> <?php echo $foutmeldingen['TelefoonErr']; ?></h5>
        <div class="d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-center align-items-center flex-wrap flex-sm-wrap flex-md-nowrap flex-lg-nowrap justify-content-xl-center align-items-xl-center flex-xl-nowrap"
             style="margin: 1em 0em;">
            <div class="d-sm-flex justify-content-start align-items-start align-content-start flex-nowrap justify-content-sm-center align-items-sm-center"
                 style="width: 100%;"><input class="form-control inputforms" type="number" name="Telefoonnummer"
                                             maxlength="10"
                                             placeholder="Telefoonnummer"></div>
        </div>
        <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center" style="color: #ffffff;">
            <?php echo genereerVraag($dbh, $vraagNummer) ?></h5>
        <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center foutmeldingTekst"> <?php echo $foutmeldingen['AntwoordErr']; ?></h5>
        <div class="d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-center align-items-center flex-wrap flex-sm-wrap flex-md-nowrap flex-lg-nowrap justify-content-xl-center align-items-xl-center flex-xl-nowrap"
             style="margin: 1em 0em;"><input
                    class="form-control inputforms" type="text"
                    placeholder="Antwoord" name="AntwoordOpVraag" autofocus="" maxlength="50"></div>

        <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center">Gebruikersnaam*</h5>
        <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center foutmeldingTekst"> <?php echo $foutmeldingen['GebruikersNaamErr']; ?></h5>
        <div class="d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-center align-items-center flex-wrap flex-sm-wrap flex-md-nowrap flex-lg-nowrap justify-content-xl-center align-items-xl-center flex-xl-nowrap"
             style="margin: 1em 0em;"><input
                    class="form-control inputforms" type="text"
                    placeholder="Gebruikersnaam" name="Gebruikersnaam" autofocus="" maxlength="50"
                    value="<?php echo isset($_POST["Gebruikersnaam"]) ? $_POST["Gebruikersnaam"] : ''; ?>"></div>

        <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center">Wachtwoord*</h5>
        <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center foutmeldingTekst"> <?php echo $foutmeldingen['wachtwoord1Err']; ?></h5>
        <div class="d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-center align-items-center flex-wrap flex-sm-wrap flex-md-nowrap flex-lg-nowrap justify-content-xl-center align-items-xl-center flex-xl-nowrap"
             style="margin: 1em 0em;"><input
                    class="form-control inputforms" type="password"
                    name="Wachtwoord" placeholder="Wachtwoord" maxlength="100"></div>

        <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center">Herhaal wachtwoord*</h5>
        <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center foutmeldingTekst"> <?php echo $foutmeldingen['wachtwoord2Err']; ?></h5>
        <div class="d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-center align-items-center flex-wrap flex-sm-wrap flex-md-nowrap flex-lg-nowrap justify-content-xl-center align-items-xl-center flex-xl-nowrap"
             style="margin: 1em 0em;"><input
                    class="form-control inputforms" type="password"
                    name="Herhaalwachtwoord" placeholder="Wachtwoord" maxlength="100"></div>
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