<?php
include_once('database.php');
include_once('functies.php');

$foutmeldingen = array("AchternaamErr" => "", "VoornaamErr" => "", "EmailErr" => "", "Adres1Err" => "", "PostcodeErr" => "", "PlaatsnaamErr" => "", "LandErr" => "", "GeboorteDatumErr" => "", "GebruikersNaamErr" => "", "wachtwoord1Err" => "", "wachtwoord2Err" => "", "AntwoordErr" => "" );
$GebruikersnaamTelling =0;
$wachtwoordMinimaalAantalTekens = 3;
$registratieGegevens = array("Emailadres" => "", "Voornaam" => "", "Achternaam" => "", "Adres_1" => "", "Adres_2" => "", "Postcode" => "", "Plaatsnaam" => "", "Land" => "", "Geboortedatum" => "", "Gebruikersnaam" => "", "Wachtwoord" => "", "AntwoordOpVraag" => "");
$registratieVraagnummer = genereerVraagNummer($dbh);
$locatieNaRegistratie = "Location: http://localhost/inlogServer/inlogScherm.php";
$registratiePagina = "";

//Kijkt of alle velden juist zijn ingevuld
    if (isset($_POST['verstuurRegistratie'])) {
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
        }


        //Vult gegevens in de database
        $EmptyTestArray = array_filter($foutmeldingen);
        if (empty($EmptyTestArray)) {
            $query = $dbh->prepare("INSERT INTO Gebruiker (Gebruikersnaam, Voornaam, Achternaam, Adres_1, Adres_2, Postcode, Plaatsnaam, Land, GeboorteDatum, Emailadres, Wachtwoord, Vraagnummer, Antwoord_tekst, Verkoper) VALUES (:Gebruikersnaam, :Voornaam, :Achternaam, :Adres_1, :Adres_2, :Postcode, :Plaatsnaam, :Land, :GeboorteDatum, :Emailadres, :Wachtwoord, :Vraagnummer, :Antwoord_tekst, :Verkoper)");

            $query->execute(
                [
                    ':Gebruikersnaam' => $registratieGegevens["Gebruikersnaam"],
                    ':Voornaam' => $registratieGegevens["Voornaam"],
                    ':Achternaam' => $registratieGegevens["Achternaam"],
                    ':Adres_1' => $registratieGegevens["Adres_1"],
                    ':Adres_2' => $registratieGegevens["Adres_2"],
                    ':Postcode' => $registratieGegevens["Postcode"],
                    ':Plaatsnaam' => $registratieGegevens["Plaatsnaam"],
                    ':Land' => $registratieGegevens["Land"],
                    ':GeboorteDatum' => $registratieGegevens["Geboortedatum"],
                    ':Emailadres' => $registratieGegevens["Emailadres"],
                    ':Wachtwoord' => password_hash($registratieGegevens["Wachtwoord"], PASSWORD_DEFAULT),
                    ':Vraagnummer' => $registratieVraagnummer,
                    ':Antwoord_tekst' => $registratieGegevens['AntwoordOpVraag'],
                    ':Verkoper' => "tes"
                ]
            );

            header($locatieNaRegistratie);
        }
    }
    if (isset($_SESSION['foutmelding'])) {
    echo $_SESSION['foutmelding'];
    $_SESSION['foutmelding'] = "";
}
?>


<form method="post" class="formulier" action="registratiesysteem.php">

    <h2>Registreren</h2>


    <label for="Voornaam"> </label><br>
    <input type="text" name="Voornaam" id="Voornaam" placeholder="Voornaam" maxlength="255" value="<?php echo isset($_POST["Voornaam"]) ? $_POST["Voornaam"] : ''; ?>"> * <?php echo $foutmeldingen['VoornaamErr'];?> <br>
    <label for="Achternaam"> </label><br>
    <input type="text" name="Achternaam" id="Achternaam" placeholder="Achternaam" maxlength="255" value="<?php echo isset($_POST["Achternaam"]) ? $_POST["Achternaam"] : ''; ?>" > * <?php echo $foutmeldingen['AchternaamErr'];?> <br>
    <label for="Adres_1"> </label><br>
    <input type="text" name="Adres_1" id="Adres_1" placeholder="Adres 1" maxlength="10" value="<?php echo isset($_POST["Adres_1"]) ? $_POST["Adres_1"] : ''; ?>"> * <?php echo $foutmeldingen['Adres1Err'];?> <br>
    <label for="Adres_2"> </label><br>
    <input type="text" name="Adres_2" id="Adres_2" placeholder="Adres 2" maxlength="15" value="<?php echo isset($_POST["Adres_2"]) ? $_POST["Adres_2"] : ''; ?>"><br>
    <label for="Postcode"> </label><br>
    <input type="text" name="Postcode" id="Postcode" placeholder="Postcode" maxlength="15" value="<?php echo isset($_POST["Postcode"]) ? $_POST["Postcode"] : ''; ?>"> * <?php echo $foutmeldingen['PostcodeErr'];?> <br>
    <label for="Plaatsnaam"> </label><br>
    <input type="text" name="Plaatsnaam" id="Plaatsnaam" placeholder="Plaatsnaam" maxlength="15" value="<?php echo isset($_POST["Plaatsnaam"]) ? $_POST["Plaatsnaam"] : ''; ?>"> * <?php echo $foutmeldingen['PlaatsnaamErr'];?> <br>
    <label for="Land"> </label><br>
    <input type="text" name="Land" id="Land" placeholder="Land" maxlength="10" value="<?php echo isset($_POST["Land"]) ? $_POST["Land"] : ''; ?>">* <?php echo $foutmeldingen['LandErr'];?> <br>
    <label for="GeboorteDatum"> </label><br>
    <input type="date" name="GeboorteDatum" id="GeboorteDatum" value="<?php echo isset($_POST["GeboorteDatum"]) ? $_POST["GeboorteDatum"] : ''; ?>"> * <?php echo $foutmeldingen['GeboorteDatumErr'];?><br>

    <label for="Gebruikersnaam"> </label><br>
    <input type="text" name="Gebruikersnaam" id="Gebruikersnaam" placeholder="Gebruikersnaam" value="<?php echo isset($_POST["Gebruikersnaam"]) ? $_POST["Gebruikersnaam"] : ''; ?>" >* <?php echo $foutmeldingen['GebruikersNaamErr'];?> <br>
    <label for="Wachtwoord"> </label><br>
    <input type="password" name="Wachtwoord" id="Wachtwoord" maxlength="255" placeholder="Wachtwoord" > * <?php echo $foutmeldingen['wachtwoord1Err'];?><br>
    <label for="Herhaalwachtwoord"> </label><br>
    <input type="password" name ="Herhaalwachtwoord" id="Herhaalwachtwoord" maxlength="255" placeholder="Herhaal wachtwoord" > * <?php echo $foutmeldingen['wachtwoord2Err'];?><br>

    <?php echo genereerVraag($dbh, $registratieVraagnummer)?>
    <label for="antwoord_op_vraag"> </label><br>
    <input type="text" name ="AntwoordOpVraag" id="AntwoordOpVraag" maxlength="255" placeholder="Vul een antwoord in op de gegeven vraag" > * <?php echo $foutmeldingen['AntwoordErr'];?><br>

    <input type="submit" name="verstuurRegistratie" Value="Registreren">
    <input type="reset" value="Cancel">

</form>
