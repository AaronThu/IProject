<?php
session_start();

include_once 'includes/database.php';
include_once "includes/functies.php";
$titel = $_POST['titel'];
$beschrijving = $_POST['beschrijving'];
$startprijs = $_POST['startprijs'];
$betalingswijze = $_POST['betalingswijze'];
$betalingsinstructie = $_POST['betalingsinstructies'];
$plaatsnaam = $_POST['locatie'];
$land = 'Nederland';
$looptijd = $_POST['looptijd'];
$verzendinstructies = $_POST['verzendinstructies'];
$Rubrieknummer = $_POST['parentrubriek'];
$verkopersID = $_SESSION['GebruikersID'];
$fileNaam = $_FILES['bestand']['name'];
$voorwerpNummer = 0;

// Upload bestanden naar server
$uploaddir = 'voorwerpenfotos/';
$uploadfile = $uploaddir . basename($_FILES['bestand']['name']);

if (move_uploaded_file($_FILES['bestand']['tmp_name'], $uploadfile)) {
    echo "Bestand is geupload\n";
} else {
    echo "Uploaden mislukt\n";
}

// Vult gegevens in de database
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

// Vult het bestand pad in de database
$query3 = $dbh->prepare("INSERT Bestand VALUES(:FileNaam, :VoorwerpNummer)");
$query3->execute(
    [
        ':FileNaam' => 'voorwerpenfotos/' . $fileNaam,
        ':VoorwerpNummer' => $voorwerpNummer,
    ]
);

// Vult het rubriek in de database
$query4 = $dbh->prepare("INSERT VoorwerpInRubriek VALUES (:Voorwerpnummer, :Rubrieknummer)");
$query4->execute(
    [
        ':Voorwerpnummer' => $voorwerpNummer,
        ':Rubrieknummer' => $Rubrieknummer,
    ]
);

// Stuurt door naar de productpagina
$locatieNaRegistratie = "Location: voorwerppagina.php?voorwerpID=$voorwerpNummer";
$_SESSION['foutmelding'] = "Voorwerp succesvol geplaatst!";
header($locatieNaRegistratie);
?>