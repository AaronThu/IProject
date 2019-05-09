<?php

function test_invoer($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
};

function vergelijkloginwaarde($vergelijken, $waarde, $dbh){
    $vergelijkloginnaam = $dbh->prepare("SELECT Gebruikersnaam, Voornaam, Achternaam, Adres1, Adres2, Postcode, Plaatsnaam, Land, GeboorteDatum, Emailadres FROM Gebruiker WHERE $vergelijken = :waarde");
    $vergelijkloginnaam->execute([':waarde' => $waarde]);
    $telling = $vergelijkloginnaam->rowCount();
    return $telling;
}

function kijkVoorLetters($string){
    return preg_match( '/[a-zA-Z]/', $string );
}

function kijkVoorCijfers($string){
    return preg_match( '/\d/', $string );
}

function kijkVoorCorrecteTekens($string){
    if (!preg_match('/[^A-Za-z0-9]+/', $string)) {
        return true;
    }else{
        return false;
    }
}

function genereerVraagNummer($dbh){
    $totaalAantalVragen = $dbh->query("SELECT * FROM Vraag");
    $rijtelling = $totaalAantalVragen->fetch();
    $nummer = mt_rand(1, count($rijtelling)-1);
    return $nummer;
}

function genereerVraag($dbh, $vraagnummer)
{
    $registratievraag = $dbh->query("SELECT Vraag FROM Vraag WHERE Vraagnummer = $vraagnummer");
    $vraagWeergave = "";
    while ($vraag = $registratievraag->fetch()) {
        $vraagWeergave .= "<p>Vul een antwoord in op de volgende vraag: $vraag[Vraag]*</p>";
    }
    return $vraagWeergave;
}


// mee bezig
function registratieFormulierItem($naamFormulier, $errorNaam, $maxLength, $type, $naamPOST){
    $waardeInForm = isset($_POST[$naamPOST]) ? $_POST[$naamPOST] : '';
    $registratieItem ="";
$registratieItem .= '<h5 class="text-center text-sm-cewnter text-md-center text-lg-left text-xl-center">' . $naamFormulier . '</h5>
            <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center foutmeldingTekst">' . $_SESSION['registratieFoutmeldingen'][$errorNaam] . '</h5>
<div class="d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-center align-items-center flex-wrap flex-sm-wrap flex-md-nowrap flex-lg-nowrap justify-content-xl-center align-items-xl-center flex-xl-nowrap"
     style="margin: 1em 0em;"><input
        class="form-control inputforms" type=' . $type.'
        placeholder="' . $naamFormulier . '"name="' . $naamPOST.'"autofocus="" maxlength="' . $maxLength.'
        "value="' . $waardeInForm . '"</div>   </div>';
    return $registratieItem;
}


function testInputVoorFouten($naamItem, $naamError, $ingevuldeWaarde){
    if (empty($ingevuldeWaarde)){
        $_SESSION['registratieFoutmeldingen'][$naamError] = "$naamItem is verplicht";
    } elseif(kijkVoorCorrecteTekens($ingevuldeWaarde) == false) {
        $_SESSION['registratieFoutmeldingen'][$naamError] = "$naamItem mag alleen letters en cijfers bevatten";
    } else{
        $_SESSION['registratieGegevens'][$naamItem] = $ingevuldeWaarde;
    }
}

