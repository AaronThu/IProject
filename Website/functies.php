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
function registratieFormulierItem($naamFormulier, $foutmeldingen, $errorNaam, $maxLength, $type){
    $registratieItem ="";
$registratieItem .= '<h5 class="text-center text-sm-cewnter text-md-center text-lg-left text-xl-center">' . $naamFormulier . '</h5><br>
            <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center foutmeldingTekst">'; echo $foutmeldingen[$errorNaam] . '</h5>
<div class="d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-center align-items-center flex-wrap flex-sm-wrap flex-md-nowrap flex-lg-nowrap justify-content-xl-center align-items-xl-center flex-xl-nowrap"
     style="margin: 1em 0em;"><input
        class="form-control inputforms" type="text"
        placeholder="Voornaam" name="Voornaam" autofocus="" maxlength="50"
        value="<?php echo isset($_POST["Voornaam"]) ? $_POST["Voornaam"] : ""; ?>"></div>';
    return $registratieItem;
}

