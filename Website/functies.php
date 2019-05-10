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

function registratieFormulierItem($naamFormulier, $errorNaam, $maxLength, $type, $naamPOST){
    $waardeInForm = isset($_POST[$naamPOST]) ? $_POST[$naamPOST] : '';
    if(empty($errorNaam)){
        $error = "";
    } else{
        $error = $_SESSION['registratieFoutmeldingen'][$errorNaam];
    }
    $registratieItem ="";
$registratieItem .= '

<h5>' . $naamFormulier . '</h5>
<h5 class="text-left foutmeldingTekst">' . $error . '</h5>
<input
        class="form-control inputforms" type=' . $type.'
        placeholder="' . $naamFormulier . '"name="' . $naamPOST.'"autofocus="" maxlength="' . $maxLength.'
        "value="' . $waardeInForm . '"</div> ';
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

