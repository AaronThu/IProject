<?php
session_Start();

include_once 'includes/database.php';
include_once 'includes/functies.php';

$locatieNaRegistratie = "Location: registreren_klaar.php";
//Vult gegevens in de database
$query = $dbh->prepare("INSERT INTO Gebruiker (Gebruikersnaam, Voornaam, Achternaam, Adres1, Adres2, Postcode, Plaatsnaam, Land, Geboortedatum, Emailadres, Wachtwoord, Vraagnummer, AntwoordTekst, SoortGebruiker) VALUES (:Gebruikersnaam, :Voornaam, :Achternaam, :Adres1, :Adres2, :Postcode, :Plaatsnaam, :Land, :Geboortedatum, :Emailadres, :Wachtwoord, :Vraagnummer, :AntwoordTekst, :SoortGebruiker)");

$query->execute(
    [
        ':Gebruikersnaam' => $_SESSION['registratieGegevens']['Gebruikersnaam'],
        ':Voornaam' => $_SESSION['registratieGegevens']['Voornaam'],
        ':Achternaam' => $_SESSION['registratieGegevens']['Achternaam'],
        ':Adres1' => $_SESSION['registratieGegevens']['Adres_1'],
        ':Adres2' => $_SESSION['registratieGegevens']['Adres_2'],
        ':Postcode' => $_SESSION['registratieGegevens']['Postcode'],
        ':Plaatsnaam' => $_SESSION['registratieGegevens']['Plaatsnaam'],
        ':Land' => $_SESSION['registratieGegevens']['Land'],
        ':Geboortedatum' => $_SESSION['registratieGegevens']['Geboortedatum'],
        ':Emailadres' => $_SESSION['Emailadres'],
        ':Wachtwoord' => password_hash($_SESSION['registratieGegevens']['Wachtwoord'], PASSWORD_DEFAULT),
        ':Vraagnummer' => $_SESSION['registratieGegevens']['vraagNummer'],
        ':AntwoordTekst' => $_SESSION['registratieGegevens']['AntwoordOpVraag'],
        ':SoortGebruiker' => 'kop',
    ]
);

$query2 = $dbh->prepare("INSERT INTO Gebruikerstelefoon(Volgnr, Gebruikersnaam, Telefoonnummer) VALUES(:Volgnr, :Gebruikersnaam, :Telefoonnummer)");

$query2->execute(
    [
        ':Volgnr' => 1,
        ':Gebruikersnaam' => $_SESSION['registratieGegevens']['Gebruikersnaam'],
        ':Telefoonnummer' => $_SESSION['registratieGegevens']['Telefoonnummer'],
    ]
);
$_SESSION['foutmelding'] = "U bent geregistreerd, u kunt nu inloggen";
header($locatieNaRegistratie);

?>


