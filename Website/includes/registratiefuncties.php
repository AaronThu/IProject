<?php
function test_invoer($data)
{
    $data = Strip_tags($data);
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
};
function kijkVoorLetters($string)
{
    return preg_match('/[a-zA-Z]/', $string);
}
//deze functie kijkt of de meegegeven string cijfers bevat
function kijkVoorCijfers($string)
{
    return preg_match('/\d/', $string);
}

function kijkVoorCorrecteTekens($string)
{
    if (preg_match("/^[a-zA-Z'. -]{2,}+$/", $string)) {
        return true;
    } else {
        return false;
    }
}
//checkt of meegegeven telefoonnummer een telefoon nummer is
function ControleerTelefoonnummer($telefoonnummer)
{

    if (preg_match("/^[0-9]{10}$/", $telefoonnummer)) {
        return true;
    } else {
        return false;
    }
}
// checkt of meetegeven postcode een postcode is
function ControleerPostcode($postcode)
{
    if (preg_match("/^[0-9]{4}[A-Za-z]{2}$/", $postcode)) {
        return true;
    } else {
        return false;
    }
}
// checkt of meegegeven geboortedatum groter is dan huideige tijd
function ControleerGeboortedatum($geboortedatum)
{
    $huidigetijd = time();
    $geboortedatumintijd = strtotime($geboortedatum);
    $minimalegeboortedatum = -2208988800;
    if ($geboortedatumintijd < $huidigetijd && $geboortedatumintijd > $minimalegeboortedatum) {
        return true;
    } else {
        return false;
    }
}
// checkt of meegegeven adres voldoet aan adres regels.
function ControleerAdres($adres)
{
    if (preg_match("/^[a-zA-Z'. -]{2,}[0-9]{1,5}+$/", $adres)) {
        return true;
    } else {
        return false;
    }
}
// returnt een random vraagnummer
function genereerVraagNummer($dbh)
{
    $totaalAantalVragen = $dbh->query("SELECT * FROM Vraag");
    $rijtelling = $totaalAantalVragen->fetch();
    $nummer = mt_rand(1, count($rijtelling) - 1);
    return $nummer;
}
//returnt een vraag uit database gebaseerd op meegegeven vraagnummer
function genereerVraag($dbh, $vraagnummer)
{
    $registratievraag = $dbh->query("SELECT Vraag FROM Vraag WHERE Vraagnummer = $vraagnummer");
    $vraagWeergave = "";
    while ($vraag = $registratievraag->fetch()) {
        $vraagWeergave .= "<p>Vul een antwoord in op de volgende vraag: $vraag[Vraag]*</p>";
    }
    return $vraagWeergave;
}
//
function registratieFormulierItem($naamFormulier, $errorNaam, $maxLength, $type, $naamPOST)
{
    $waardeInForm = isset($_POST[$naamPOST]) ? $_POST[$naamPOST] : '';
    if (empty($errorNaam)) {
        $error = "";
    } else {
        $error = $_SESSION['registratieFoutmeldingen'][$errorNaam];
    }
    $registratieItem = "";
    $registratieItem .= '
<h6>' . $naamFormulier . '</h6>
<h6 class="text-left foutmeldingTekst">' . $error . '</h6>
<input
        class="form-control inputforms" type=' . $type . '
        placeholder=""name="' . $naamPOST . '"autofocus="" maxlength="' . $maxLength . '
        "value="' . $waardeInForm . '"</div> ';
    return $registratieItem;
}
//returned landen uit database
function GeefLandenLijst($dbh)
{
    $landenQuery = $dbh->prepare("SELECT * FROM Landen");
    $landenQuery->execute();
    $landen = $landenQuery->fetchAll();
    return $landen;
}
//checkt of iets is ingevuld en checkt of fout ontstaat,zet foutmeldingen in een array
function testInputVoorFouten($naamItem, $naamError, $ingevuldeWaarde)
{
    if (empty($ingevuldeWaarde)) {
        $_SESSION['registratieFoutmeldingen'][$naamError] = "$naamItem is verplicht";
    } elseif (kijkVoorCorrecteTekens($ingevuldeWaarde) == false) {
        $_SESSION['registratieFoutmeldingen'][$naamError] = "$naamItem invoer is incorrect";
    } else {
        $_SESSION['registratieGegevens'][$naamItem] = $ingevuldeWaarde;
    }
}

function genereerVerkoperRegistratieCode()
{
    $verkoperRegistratieCode = "";

    for ($i = 0; $i < 7; $i++) {
        $verkoperRegistratieCode .= rand(0, 9);
    }
    return $verkoperRegistratieCode;
}

function maakBestandAanVoorRegistratie($VerkopersCode, $Voornaam, $Gebruikersnaam)
{
    $bestand = fopen("verkoperscode/$Gebruikersnaam", "w");
    $tekst = "Beste $Voornaam,\n
    U heeft een registratie aangevraagd om verkoper te worden op EenmaalAndermaal\n
    voor de gebruiker $Gebruikersnaam.\n
    Om deze registratie te voltooien moet u een code invoeren op de website.\n
    Zodra u op de website inlogt, drukt u rechtsboven op de knop code invoeren, en vult\n
    u de volgende code in:\n
    CODE: $VerkopersCode";
    fwrite($bestand, $tekst);
    fclose($bestand);
}
function vergelijkVerkopersRegistratieCode($GebruikersID, $code, $dbh)
{
    $vergelijkCode = $dbh->prepare("SELECT GebruikersID, VerkopersCode, CodeVerlopen FROM VerkopersCode WHERE GebruikersID = :GebruikersID AND VerkopersCode = :VerkopersCode");
    $vergelijkCode->execute([
        ':GebruikersID' => $GebruikersID,
        ':VerkopersCode' => $code
        ]);

    $waardes = [];
    while ($rij = $vergelijkCode->fetch()) {
        $waardes = ["$rij[GebruikersID]", "$rij[VerkopersCode]", "$rij[CodeVerlopen]"];
    }

    return $waardes;
}

//veranderd het soortgebruiker naar meegegen soortgebruiker van meegegeven gebruiker id
function updateSoortGebruikerStatus($dbh, $soortGebruiker, $gebruikersID)
{
    $query = $dbh->prepare("UPDATE Gebruiker SET SoortGebruiker = $soortGebruiker WHERE GebruikersID = :gebruikersID");
    $query->execute([':gebruikersID' => $gebruikersID]);
}


function updateVerkoperStatus($dbh, $gebruikersID)
{
    $query = $dbh->prepare("UPDATE Verkoper SET Status = 'geactiveerd' WHERE GebruikersID = :gebruikersID");
    $query->execute([':gebruikersID' => $gebruikersID]);
    return "hoi";
}

//deze functie kijkt of de meegegeven string letters bevat a t/m z en hoofdletters

// returned banken uit database
function GeefBankenLijst($dbh)
{
    $bankenQuery = $dbh->prepare("SELECT * FROM Banken");
    $bankenQuery->execute();
    $banken = $bankenQuery->fetchAll();
    return $banken;
}
