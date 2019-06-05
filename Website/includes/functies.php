<?php

//======================================FORMULIEREN FUNCTIES============================================
function test_invoer($data)
{
    $data = Strip_tags($data);
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
};

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
    $bestand = fopen("$Gebruikersnaam", "w");
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

function vergelijkloginwaarde($vergelijken, $waarde, $dbh)
{
    $vergelijkloginnaam = $dbh->prepare("SELECT Gebruikersnaam, Voornaam, Achternaam, Adres1, Adres2, Postcode, Plaatsnaam, Land, GeboorteDatum, Emailadres FROM Gebruiker WHERE $vergelijken = :waarde");
    $vergelijkloginnaam->execute([':waarde' => $waarde]);
    $telling = $vergelijkloginnaam->rowCount();
    return $telling;
}

function vergelijkVerkopersRegistratieCode($vergelijken, $code, $dbh)
{
    $vergelijkCode = $dbh->prepare("SELECT GebruikersID, VerkopersCode, CodeVerlopern FROM VerkopersCode WHERE $vergelijken = :Waarde");
    $vergelijkCode->execute([':Waarde' => $code]);

    $waardes = [];
    while ($rij = $vergelijkCode->fetch()) {
        $waardes = ["$rij[GebruikersID]", "$rij[VerkopersCode]", "$rij[CodeVerlopern]"];
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
    $query = $dbh->prepare("UPDATE Verkoper SET Status = geactiveerd WHERE GebruikersID = :gebruikersID");
    $query->execute([':gebruikersID' => $gebruikersID]);
}
//deze functie kijkt of de meegegeven string letters bevat a t/m z en hoofdletters
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
// returned banken uit database
function GeefBankenLijst($dbh)
{
    $bankenQuery = $dbh->prepare("SELECT * FROM Banken");
    $bankenQuery->execute();
    $banken = $bankenQuery->fetchAll();
    return $banken;
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

// returned of meegegeven gebruiker verkoper is.
function IsVerkoper($userID)
{
    global $dbh;
    $Query = $dbh->prepare("SELECT count(Gebruikersnaam) FROM Gebruiker WHERE Gebruikersnaam = ? AND SoortGebruiker = 'verkoper'");
    $Query->execute([$userID]);
    return $Query->fetchAll()[0][0] > 0;
}

//===========================HOMEPAGE FUNCTIES======================================================================
// returnt artiekel op meegegeven query en columtype. (voor kaartjes op de homepagina)
function genereerArtikelen($dbh, $gegevenQuery, $columntype)
{
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

        $artikelen .= '<div id = "hover" class=" ' . $columntype . ' tile kaartje" prijs-hover=' . "€" .  $Verkoopprijs . ' >
        
        <a href = "voorwerppagina.php?voorwerpID=' . $voorwerpNummer . '" class="d-flex flex-column justify-content-between align-content-start"style="height: 149px;background-image: url(http://iproject2.icasites.nl/pics/' . $foto . '); background-size: contain;" >
        <p class="kaartje Timer d-flex align-items-start align-content-start align-self-start" data-time="' . $tijd . '" style="background-color: rgba(75,76,77,0.75);color: #ffffff;"></p>
        <p class="kaartje text-left" style="background-color: rgba(75,76,77,0.75);color: #ffffff;">' . substr($titel, 0, 25) . '... </p>
                     </a>
                     
            </div>';
    }

    return $artikelen;
}

// maakt een colom met catogorieen met mee gegeven querey en columtype
function genereerCatogorie($dbh, $gegevenQuery, $columntype)
{
    $catogorie = '';

    $querycatogorie = $dbh->query("$gegevenQuery");
    while ($row = $querycatogorie->fetch()) {
        $rubriekNaam = $row['Rubrieknaam'];
        $rubriekNummer = $row['Rubrieknummer'];

        $queryFoto = $dbh->prepare("SELECT * FROM RubriekFotos WHERE Rubrieknummer = :Rubrieknummer");
        $queryFoto->execute([
            ":Rubrieknummer" => $rubriekNummer,
        ]);
        $foto = $queryFoto->fetchColumn(1);

        $catogorie .= '<div class=" ' . $columntype . '" data-hover=' . $rubriekNaam . ' >
        <a href = "subrubrieken_pagina.php?rubriekID=' . $rubriekNummer . '"><div class="d-flex flex-column justify-content-between align-content-start" style="height: 250px;">
               <img style="border-radius: 50%;" src="assets/img/Rubrieken/' . $foto . '" alt="' . $foto . '" height=250; width=250;> 
               </div>
               </a>   
            </div>';
    }

    return $catogorie;
}


function genereerArtikel($titel, $tijd, $StartPrijs, $Verkoopprijs, $voorwerpNummer, $columntype)
{
    echo ('<div id = "hover" class=" ' . $columntype . ' tile kaartje" prijs-hover=' . "€" .  $Verkoopprijs . ' >');
    echo ('<a href = "voorwerppagina.php?voorwerpID=' . $voorwerpNummer . '" class="d-flex flex-column justify-content-between align-content-start"style="height: 149px;background-image: url(http://iproject2.icasites.nl/pics/' .  GetVoorwerpFoto($voorwerpNummer)[0][0] . '); background-size: contain;" >');
    echo ('<p class="kaartje Timer d-flex align-items-start align-content-start align-self-start" data-time="' . $tijd . '" style="background-color: rgba(75,76,77,0.75);color: #ffffff;"></p>');
    echo ('<p class ="kaartje text-left" style ="background-color: rgba(75,76,77,0.75);color: #ffffff; " >' . substr($titel, 0, 25) .  '... </p></a></div>');
}


function MinimaleBiedPrijs($HoogsteBod){
    $MinimaalTeBieden = 0;
    switch ($MinimaalTeBieden) {

        case $HoogsteBod <= 49.99;
            $MinimaalTeBieden = 0.50;
            break;
        case $HoogsteBod <= 499.99:
            $MinimaalTeBieden = 1.00;
            break;
        case $HoogsteBod <= 999.99:
            $MinimaalTeBieden = 5.00;
            break;
        case $HoogsteBod <= 4999.99:
            $MinimaalTeBieden = 10.00;
            break;
        case $HoogsteBod >= 5000.00:
            $MinimaalTeBieden = 50.00;
            break;
    }
    return $MinimaalTeBieden;
}