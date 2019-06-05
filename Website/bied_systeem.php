<?php
session_start();

include_once 'includes/database.php';
include_once 'includes/functies.php';
include_once 'includes/databaseFunctions.php';

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
$HoogsteBod = GetHoogsteBod($voorwerpID);
$BiedenGeslaagdTekst = "Bod succesvol geplaatst";

if(empty($HoogsteBod)) {
    $HoogsteBod = $voorwerpEigenschappen[0]['Startprijs'] - 50;
}

switch($_SESSION['foutmelding']){
    case $Bodbedrag < $voorwerpEigenschappen[0]['Startprijs']:
        $_SESSION['foutmelding'] = "Bieden mislukt - U bied minder dan de startprijs: €" . $voorwerpEigenschappen[0]["Startprijs"];
        header($locatieBiedingMislukt);
        break;
    case $Bodbedrag < $HoogsteBod:
        $_SESSION['foutmelding'] = "Bieden mislukt - U bied minder dan het hoogste bod: $HoogsteBod";
        header($locatieBiedingMislukt);
        break;
    case $GebruikerID == $voorwerpEigenschappen[0]['VerkopersID']:
        $_SESSION['foutmelding'] = "Bieden mislukt - u mag niet op uw eigen geplaatste producten bieden";
        header($locatieBiedingMislukt);
        break;
}

if($Bodbedrag >= $voorwerpEigenschappen[0]['Startprijs'] && $Bodbedrag >= $HoogsteBod) {
    $MinimaalTeBieden = MinimaleBiedPrijs($HoogsteBod);

    if($Bodbedrag - $HoogsteBod >= $MinimaalTeBieden) {

        $query = $dbh->prepare("INSERT Bod (Voorwerpnummer, Bodbedrag, GebruikersID) VALUES ($voorwerpID, $Bodbedrag, $GebruikerID)");
        $query->execute();
        VoegNotificatieToe($voorwerpEigenschappen[0]['VerkopersID'], $voorwerpID, 'bodGeplaatst');
        UpdateVoorwerpKopersIDEnPrijs($GebruikerID, $voorwerpID, $Bodbedrag);
        if(!empty($HoogsteBod)){
            if($HoogsteBod != $GebruikerID)
                VoegNotificatieToe($HoogsteBod, $voorwerpID, 'voorwerpOverboden');
        }
        $_SESSION['foutmelding'] = $BiedenGeslaagdTekst;
        header($locatieBiedingMislukt);
    }
    else {
        $_SESSION['foutmelding'] = "U moet minimaal € $MinimaalTeBieden meer bieden";
        header($locatieBiedingMislukt);
    }

}
?>