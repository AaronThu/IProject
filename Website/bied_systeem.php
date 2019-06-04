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

if(empty($HoogsteBod[0]['Bodbedrag'])) {
    $HoogsteBod[0]['Bodbedrag'] = $voorwerpEigenschappen[0]['Startprijs'] - 50;
}

if($Bodbedrag < $voorwerpEigenschappen[0]['Startprijs']) {
    $_SESSION['foutmelding'] = "Bieden mislukt - Bod is lager dan de startprijs";
    header($locatieBiedingMislukt);
}
else if($Bodbedrag < $HoogsteBod[0]['Bodbedrag']) {
    $_SESSION['foutmelding'] = "Bieden mislukt - Bod is lager dan het hoogste bod";
    header($locatieBiedingMislukt);
}
else if($Bodbedrag >= $voorwerpEigenschappen[0]['Startprijs'] && $Bodbedrag >= $HoogsteBod[0]['Bodbedrag']) {
    if($HoogsteBod[0]['Bodbedrag'] >= 1.00 && $HoogsteBod[0]['Bodbedrag'] <= 49.99) {
        $MinimaalTeBieden = 0.50;  
    }
    else if($HoogsteBod[0]['Bodbedrag'] >= 50.00 && $HoogsteBod[0]['Bodbedrag'] <= 499.99) {
        $MinimaalTeBieden = 1.00;
    }
    else if($HoogsteBod[0]['Bodbedrag'] >= 500.00 && $HoogsteBod[0]['Bodbedrag'] <= 999.99) {
        $MinimaalTeBieden = 5.00;
    }
    else if($HoogsteBod[0]['Bodbedrag'] >= 1000.00 && $HoogsteBod[0]['Bodbedrag'] <= 4999.99) {
        $MinimaalTeBieden = 10.00;  
    }
    else if($HoogsteBod[0]['Bodbedrag'] >= 5000.00) {
        $MinimaalTeBieden = 50.00;
    }

    if($Bodbedrag - $HoogsteBod[0]['Bodbedrag'] >= $MinimaalTeBieden) {

        $query = $dbh->prepare("INSERT Bod (Voorwerpnummer, Bodbedrag, GebruikersID) VALUES ($voorwerpID, $Bodbedrag, $GebruikerID)");
        $query->execute();
        VoegNotificatieToe($voorwerpEigenschappen[0]['VerkopersID'], $voorwerpID, 'bodGeplaatst');
        UpdateVoorwerpKopersID($GebruikerID, $voorwerpID);
        if(!empty($HoogsteBod[0]['GebruikersID'])){
            if($HoogsteBod[0]['GebruikersID'] != $GebruikerID)
            VoegNotificatieToe($HoogsteBod[0]['GebruikersID'], $voorwerpID, 'voorwerpOverboden');
        }
        $_SESSION['foutmelding'] = $BiedenGeslaagdTekst;
        header($locatieBiedingMislukt);
    }
    else {
        $_SESSION['foutmelding'] = "Bied minimaal € $MinimaalTeBieden meer";
        header($locatieBiedingMislukt);
    }
}
?>