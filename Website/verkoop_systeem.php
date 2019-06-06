<?php
session_start();

include_once 'includes/database.php';
include_once 'includes/functies.php';

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
$fileNaam = $_FILES['bestand']['name'];
$voorwerpNummer = 0;

echo $titel . "<br>";
echo $beschrijving . "<br>";
echo $startprijs . "<br>";
echo $betalingswijze . "<br>";
echo $betalingsinstructie . "<br>";
echo $plaatsnaam . "<br>";
echo $land . "<br>";
echo $looptijd . "<br>";
echo $verzendinstructies . "<br>";
echo $verkopersID . "<br>";
echo $_FILES['bestand']['name'] . "<br>";

// upload bestanden naar server
$uploaddir = 'voorwerpenfotos/';
$uploadfile = $uploaddir . basename($_FILES['bestand']['name']);

if (move_uploaded_file($_FILES['bestand']['tmp_name'], $uploadfile)) {
    echo "Bestand is geupload\n";
} else {
    echo "Uploaden mislukt\n";
}

//Vult gegevens in de database
$query = $dbh->prepare("INSERT Voorwerp (Titel, Beschrijving, Startprijs, Betalingswijze, Betalingsinstructie, Plaatsnaam, Land, Looptijd, Verzendinstructies, VerkopersID) 
VALUES (:Titel, :Beschrijving, :Startprijs, :Betalingswijze, :Betalingsinstructie, :Plaatsnaam, :Land, :Looptijd, :Verzendinstructies, :VerkopersID)");
$query->execute(
    [
        ':Titel' => $titel,
        ':Beschrijving' => $beschrijving,
        ':Startprijs' => $startprijs,
        ':Betalingswijze' => $betalingswijze,
        ':Betalingsinstructie' => $betalingsinstructie,
        ':Plaatsnaam' => $plaatsnaam,
        ':Land' => $land,
        ':Looptijd' => $looptijd,
        ':Verzendinstructies' => $verzendinstructies,
        ':VerkopersID' => $verkopersID,
    ]
);

//Haalt voorwerpnummer uit database
$query2 = $dbh->prepare("SELECT Voorwerpnummer FROM Voorwerp WHERE Titel = :Titel AND Beschrijving = :Beschrijving");
$query2->execute(
    [
        ':Titel' => $titel,
        ':Beschrijving' => $beschrijving,
    ]
);

while ($rij = $query2->fetch()) {
    $voorwerpNummer = $rij['Voorwerpnummer'];
}

$query3 = $dbh->prepare("INSERT Bestand VALUES(:FileNaam, :VoorwerpNummer)");
$query3->execute(
    [
        ':FileNaam' => 'voorwerpenfotos/' . $fileNaam,
        ':VoorwerpNummer' => $voorwerpNummer,
    ]
);
echo $voorwerpNummer;
$locatieNaRegistratie = "Location: voorwerppagina.php?voorwerpID=$voorwerpNummer";
$_SESSION['foutmelding'] = "Voorwerp succesvol geplaatst!";
header($locatieNaRegistratie);
?>