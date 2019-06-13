<?php
session_start();

include_once 'includes/database.php';
include_once "includes/functies.php";

$voorwerpID = 0;
if (!isset($_GET["voorwerpID"])) {
    return;
}
$voorwerpID = test_invoer($_GET["voorwerpID"]);
if (!is_numeric($voorwerpID)) {
    return;
}

$locatieBiedingMislukt = "Location: voorwerppagina.php?voorwerpID=$voorwerpID";
$Bodbedrag = $_POST['bodbedrag'];
$GebruikerID =  $_SESSION['GebruikersID'];
$Bodtijd = date('Y-m-d H:i:s');
$voorwerpEigenschappen = GetVoorwerpEigenschappen($voorwerpID);
$HoogsteBod = $voorwerpEigenschappen[0]['Verkoopprijs'];
$biederHoogsteBod = $voorwerpEigenschappen[0]['KopersID'];
$BiedenGeslaagdTekst = "Bod succesvol geplaatst";

// Bied systeem
if(empty($voorwerpEigenschappen[0]['Verkoopprijs'])) {
    $HoogsteBod = $voorwerpEigenschappen[0]['Startprijs'] - MinimaleBiedPrijs($voorwerpEigenschappen[0]['Startprijs']);
}

if($Bodbedrag < $voorwerpEigenschappen[0]['Startprijs']){
    $_SESSION['foutmelding'] = "Bieden mislukt - U bied minder dan de startprijs: €" . $voorwerpEigenschappen[0]["Startprijs"];
    header($locatieBiedingMislukt);
    return;
} elseif($Bodbedrag < $HoogsteBod){
    $_SESSION['foutmelding'] = "Bieden mislukt - U bied minder dan het hoogste bod: $HoogsteBod";
    header($locatieBiedingMislukt);
    return;
} elseif($GebruikerID == $voorwerpEigenschappen[0]['VerkopersID']){
    $_SESSION['foutmelding'] = "Bieden mislukt - u mag niet op uw eigen geplaatste producten bieden";
    header($locatieBiedingMislukt);
    return;
} elseif($Bodbedrag > 999999999.99){
    $_SESSION['foutmelding'] = "Bieden mislukt - u mag maximaal €999999999.99 bieden";
    header($locatieBiedingMislukt);
    return;
}

if($Bodbedrag >= $voorwerpEigenschappen[0]['Startprijs'] && $Bodbedrag >= $HoogsteBod) {
    $MinimaalTeBieden = MinimaleBiedPrijs($HoogsteBod);

    if ($Bodbedrag - $HoogsteBod >= $MinimaalTeBieden) {
        $query = $dbh->prepare("INSERT Bod (Voorwerpnummer, Bodbedrag, GebruikersID) VALUES ($voorwerpID, $Bodbedrag, $GebruikerID)");
        $query->execute();
        VoegNotificatieToe($voorwerpEigenschappen[0]['VerkopersID'], $voorwerpID, 'bodGeplaatst');
        if (!empty($biederHoogsteBod) && $biederHoogsteBod != $GebruikerID) {
            VoegNotificatieToe($biederHoogsteBod, $voorwerpID, 'voorwerpOverboden');
        }
        $_SESSION['foutmelding'] = $BiedenGeslaagdTekst;
        header($locatieBiedingMislukt);
    } else {
            $_SESSION['foutmelding'] = "U moet minimaal € $MinimaalTeBieden meer bieden";
            header($locatieBiedingMislukt);
        }
}
?>