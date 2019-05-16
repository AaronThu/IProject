<?php

//FORMULIEREN FUNCTIES
function test_invoer($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
};

function vergelijkloginwaarde($vergelijken, $waarde, $dbh) {
    $vergelijkloginnaam = $dbh->prepare("SELECT Gebruikersnaam, Voornaam, Achternaam, Adres1, Adres2, Postcode, Plaatsnaam, Land, GeboorteDatum, Emailadres FROM Gebruiker WHERE $vergelijken = :waarde");
    $vergelijkloginnaam->execute([':waarde' => $waarde]);
    $telling = $vergelijkloginnaam->rowCount();
    return $telling;
}

function kijkVoorLetters($string) {
    return preg_match('/[a-zA-Z]/', $string);
}

function kijkVoorCijfers($string) {
    return preg_match('/\d/', $string);
}

function kijkVoorCorrecteTekens($string){
    if (preg_match("/^[a-zA-Z'. -]{2,}+$/", $string)) {
        return true;
    }else{
        return false;
    }
}

function ControleerTelefoonnummer($telefoonnummer) {

    if (preg_match("/^[0-9]{10}$/", $telefoonnummer)) {
        return true;
    } else {
        return false;
    }
}

function ControleerPostcode($postcode) {
    if(preg_match("/^[0-9]{4}[A-Za-z]{2}$/", $postcode)) {
        return true;
    }else{
        return false;
    }
}

function ControleerGeboortedatum($geboortedatum) {
    $huidigetijd = time();
    $geboortedatumintijd = strtotime($geboortedatum);
    $minimalegeboortedatum = -2208988800;
    if ($geboortedatumintijd < $huidigetijd && $geboortedatumintijd > $minimalegeboortedatum) {
        return true;
    }
    else {
        return false;
    }

}

function ControleerAdres($adres)
 {
    if (preg_match("/^[a-zA-Z'. -]{2,}[0-9]{1,3}+$/", $adres)) {
         return true;
     }
     else {
         return false;
     }
 }

function genereerVraagNummer($dbh) {
    $totaalAantalVragen = $dbh->query("SELECT * FROM Vraag");
    $rijtelling = $totaalAantalVragen->fetch();
    $nummer = mt_rand(1, count($rijtelling) - 1);
    return $nummer;
}

function genereerVraag($dbh, $vraagnummer) {
    $registratievraag = $dbh->query("SELECT Vraag FROM Vraag WHERE Vraagnummer = $vraagnummer");
    $vraagWeergave = "";
    while ($vraag = $registratievraag->fetch()) {
        $vraagWeergave .= "<p>Vul een antwoord in op de volgende vraag: $vraag[Vraag]*</p>";
    }
    return $vraagWeergave;
}

function registratieFormulierItem($naamFormulier, $errorNaam, $maxLength, $type, $naamPOST) {
    $waardeInForm = isset($_POST[$naamPOST]) ? $_POST[$naamPOST] : '';
    if (empty($errorNaam)) {
        $error = "";
    } else {
        $error = $_SESSION['registratieFoutmeldingen'][$errorNaam];
    }
    $registratieItem = "";
    $registratieItem .= '
<h5>' . $naamFormulier . '</h5>
<h5 class="text-left foutmeldingTekst">' . $error . '</h5>
<input
        class="form-control inputforms" type=' . $type . '
        placeholder=""name="' . $naamPOST . '"autofocus="" maxlength="' . $maxLength . '
        "value="' . $waardeInForm . '"</div> ';
    return $registratieItem;
}

function testInputVoorFouten($naamItem, $naamError, $ingevuldeWaarde) {
    if (empty($ingevuldeWaarde)) {
        $_SESSION['registratieFoutmeldingen'][$naamError] = "$naamItem is verplicht";
    } elseif (kijkVoorCorrecteTekens($ingevuldeWaarde) == false) {
        $_SESSION['registratieFoutmeldingen'][$naamError] = "$naamItem invoer is incorrect";
    } else {
        $_SESSION['registratieGegevens'][$naamItem] = $ingevuldeWaarde;
    }
}

//HOMEPAGE FUNCTIES
function genereerArtikelen($dbh, $gegevenQuery, $columntype) {
    $artikelen = '';

    $queryvoorwerpen = $dbh->query("$gegevenQuery");
    while ($row = $queryvoorwerpen->fetch()) {
        $titel = $row['Titel'];
        $tijd = $row['Eindmoment'];
        $StartPrijs = $row['Startprijs'];
        $Verkoopprijs = $row['Startprijs'];
        $voorwerpNummer = $row['Voorwerpnummer'];

        $queryFoto = $dbh->prepare("SELECT * FROM Bestand WHERE Voorwerpnummer = :Voorwerpnummer");
        $queryFoto->execute([
            ":Voorwerpnummer" => $voorwerpNummer,
        ]);
        $foto = $queryFoto->fetchColumn();

        $artikelen .= '<div class=" ' . $columntype . '" data-hover=' . "€" . $Verkoopprijs . ' >
                <div class="d-flex flex-column justify-content-between align-content-start" style="height: 149px;background-image: url(assets/img/' . $foto . '); background-size: cover">
                    <p class="Timer d-flex align-items-start align-content-start align-self-start" data-time="' . $tijd . '" style="background-color: rgba(75,76,77,0.75);color: #ffffff;"></p>
                    <p class="text-left" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">' . $titel . '</p>
                </div>
            </div>';

    }

    return $artikelen;
}
