<?php
session_start();
include_once "includes/database.php";
include_once "includes/functies.php";

// Controlleerd of gebruiker is ingelogd
if (empty($_SESSION['controleOptie'])) {
    $_SESSION['foutmelding'] = "Je moet eerst registreren/inloggen als gebruiker voordat je mag registreren als verkoper";
    header("Location: index.php");
    return;
}

$locatieNaRegistratie = "Location: index.php";
$status = "";

// Haalt gebuikersnaam uit de database
$queryGebruikersID = $dbh->prepare("SELECT GebruikersID FROM Gebruiker WHERE Gebruikersnaam = :gebruikersnaam");
$queryGebruikersID->execute(
    [
        ':gebruikersnaam' => $_SESSION['Gebruikersnaam']
    ]
);

$gebruikersID = $queryGebruikersID->fetch()[0];

// Controlleerd de controle optie + gegevens in database zetten
if( $_SESSION['controleOptie'] == 'Post'){
    $status = "aanvraging";
    $_SESSION['foutmelding'] = "Uw registratie is in aanvraging, er wordt binnen vijf werkdagen een brief met een code naar u gestuurd.\n";
    $_SESSION['foutmelding'] .= "Uw gegevens zijn tijdelijk opgeslagen totdat u uw account activeert.";
$verkoperRegistratieCode = genereerVerkoperRegistratieCode();
$query = $dbh->prepare("INSERT INTO VerkopersCode(GebruikersID, VerkopersCode) VALUES (:GebruikersID, :VerkopersCode)");
$query->execute(
    [
        ':GebruikersID' => $gebruikersID,
        ':VerkopersCode' => $verkoperRegistratieCode
    ]
);

maakBestandAanVoorRegistratie($verkoperRegistratieCode, $_SESSION['Voornaam'], $_SESSION['Gebruikersnaam']);

} elseif( $_SESSION['controleOptie'] == 'Creditcard') {
    $status = "geactiveerd";
    $_SESSION['foutmelding'] = "U bent geregistreerd als verkoper, u kunt nu voorwerpen aanbieden op de website";
    $_SESSION['SoortGebruiker'] = 'verkoper';
    $_SESSION['VerkoperStatus'] = 'geactiveerd';
} else{
    $_SESSION['foutmelding'] = "Er is iets fout gegaan met het registreren, probeer het opnieuw";
    header("Location: registreren_verkoper.php");
    return;
}

// Update de database (maakt gebruiker verkoper)
$updateGebruiker = $dbh->prepare("UPDATE Gebruiker SET SoortGebruiker = 'verkoper' WHERE GebruikersID = :GebruikersID");
$updateGebruiker->execute(
    [
        ':GebruikersID' => $_SESSION['GebruikersID']
    ]
);

// Vult de verkoper gegevens in de database in
$query = $dbh->prepare("INSERT INTO Verkoper (GebruikersID, SoortRekening, Bank, Rekeningnummer, BankRekeningHouder, EinddatumPas, ControleOptieNaam, Status) VALUES (:GebruikersID, :SoortRekening, :Bank, :Rekeningnummer, :BankRekeningHouder, :EinddatumPas, :ControleOptieNaam, :Status)");

$query->execute(
    [
        ':GebruikersID' => $gebruikersID,
        ':SoortRekening' => $_SESSION['SoortRekening'],
        ':Bank' => $_SESSION['Bank'],
        ':Rekeningnummer' => $_SESSION['Rekeningnummer'],
        ':BankRekeningHouder' => $_SESSION['rekeningHouder'],
        ':EinddatumPas' => $_SESSION['einddatum'],
        ':ControleOptieNaam' =>  $_SESSION['controleOptie'],
        ':Status' => $status
    ]
);
header($locatieNaRegistratie);
?>