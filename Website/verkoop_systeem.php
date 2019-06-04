<?php
session_start();

include_once 'includes/database.php';
include_once 'includes/functies.php';

$locatieNaRegistratie = "Location: index.php";
$titel = $_POST['titel'];
$beschrijving = $_POST['beschrijving'];
$startprijs = $_POST['startprijs'];
$betalingswijze = $_POST['betalingswijze'];
$betalingsinstructie = $_POST['betalingsinstructies'];
$plaatsnaam = $_POST['locatie'];
$land = 'Nederland';
$looptijd = $_POST['looptijd'];
$verzendinstructies = $_POST['verzendinstructies'];
$verkopersID = $_SESSION['GebruikersID'];
$filenaam = $_FILES['bestand']['name'];

$voorwerpNummer = 0;

echo $titel . "<br>";
echo $beschrijving . "<br>";
echo $startprijs . "<br>";
echo $betalingswijze . "<br>";
echo $betalingsinstructie . "<br>";
echo $plaatsnaam . "<br>";
echo $land . "<br>";
echo $looptijd . "<br>";
echo $verkopersID . "<br>";
echo $_FILES['bestand']['name'] . "<br>";

// upload bestanden naar server
$uploaddir = 'upload/';
$uploadfile = $uploaddir . basename($_FILES['bestand']['name']);

if (move_uploaded_file($_FILES['bestand']['tmp_name'], $uploadfile)) {
    echo "Bestand is geupload\n";
} else {
    echo "Uploaden mislukt\n";
}

//Vult gegevens in de database
$query = $dbh->prepare("INSERT Voorwerp (Titel, Beschrijving, Startprijs, Betalingswijze, Betalingsinstructie, Plaatsnaam, Land, Looptijd, Verzendinstructies, VerkopersID) 
VALUES ($titel, $beschrijving, $startprijs, $betalingswijze, $betalingsinstructie, $plaatsnaam, $land, $looptijd, $verzendinstructies, $verkopersID)");
$query->execute();

// $query2 = $dbh->prepare("INSERT Bestand VALUES($fileNaam, $voorwerpNummer)");
// $query2->execute();

// $_SESSION['foutmelding'] = "Voorwerp succesvol geplaatst";
// header($locatieNaRegistratie);
?>