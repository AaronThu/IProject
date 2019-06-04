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
// $verzendinstructies = $_POST['verzendinstructies'];
$verkopersID = $_SESSION['GebruikersID'];
$filenaam = $_FILES['bestand']['name'];

$voorwerpNummer = 0;

// echo $titel;
// echo $beschrijving;
// echo $startprijs;
// echo $betalingswijze;
// echo $betalingsinstructie;
// echo $plaatsnaam;
// echo $land;
// echo $looptijd;
// echo $verkopersID;
// echo $_FILES['bestand']['name'];

// upload bestanden naar server
$uploaddir = 'upload/';
$uploadfile = $uploaddir . basename($_FILES['bestand']['name']);

if (move_uploaded_file($_FILES['bestand']['tmp_name'], $uploadfile)) {
    echo "Bestand is geupload\n";
} else {
    echo "Uploaden mislukt\n";
}

//Vult gegevens in de database
$query = $dbh->prepare("INSERT Voorwerp (Titel, Beschrijving, Startprijs, Betalingswijze, Betalingsinstructie, Plaatsnaam, Land, Looptijd, VerkopersID) 
VALUES ('$titel', '$beschrijving', '$startprijs', '$betalingswijze', '$betalingsinstructie', '$plaatsnaam', '$land', '$looptijd', '$verkopersID')");
$query->execute();

// $query2 = $dbh->prepare("INSERT Bestand VALUES($fileNaam, $voorwerpNummer)");
// $query2->execute();

// $_SESSION['foutmelding'] = "Voorwerp succesvol geplaatst";
// header($locatieNaRegistratie);
?>