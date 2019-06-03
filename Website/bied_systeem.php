<?php
session_start();

include_once 'includes/database.php';
include_once 'includes/functies.php';


$voorwerpID = 0;
if (!isset($_GET["voorwerpID"])) {
    return;
}
$voorwerpID = test_invoer($_GET["voorwerpID"]);
if (!is_numeric($voorwerpID)) {
    return;
}

$locatieNaRegistratie = "Location: voorwerppagina.php?voorwerpID=$voorwerpID";
$Bodbedrag = $_POST['bodbedrag'];
$GebruikerID =  $_SESSION['GebruikersID'];
$Bodtijd = date('Y-m-d H:i:s');

echo $voorwerpID . "<br>";
echo $Bodbedrag . "<br>";
echo $GebruikerID . "<br>";
echo $Bodtijd . "<br>";

//Vult gegevens in de database
$query = $dbh->prepare("INSERT Bod (Voorwerpnummer, Bodbedrag, GebruikersID) VALUES ($voorwerpID, $Bodbedrag, $GebruikerID)");
$query->execute();

$_SESSION['foutmelding'] = "Uw bod is geplaatst";
header($locatieNaRegistratie);

?>