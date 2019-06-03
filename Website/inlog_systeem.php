<?php
session_Start();
include_once 'includes/database.php';
include_once 'includes/functies.php';
include_once 'beheerder/logica/databaseFuncties.php';
$locatie = "Location: login_pagina.php";
if (isset($_POST['inloggen'])) {
    $Gebruikersnaam = test_invoer($_POST['Gebruikersnaam']);
    $wachtwoord = test_invoer($_POST['Wachtwoord']);
    $wachtwoordofgebruikersnaamfout = "Het wachtwoord of de gebruikersnaam is fout, probeer het opnieuw";
    $query = $dbh->prepare("SELECT Wachtwoord, Voornaam, Achternaam, Adres1, Adres2, Postcode, Plaatsnaam, Land, Geboortedatum, Emailadres, GebruikersID, SoortGebruiker FROM Gebruiker WHERE Gebruikersnaam = :Gebruikersnaam");
    $query->execute([':Gebruikersnaam' => $Gebruikersnaam]);
    $hash = [];

    while ($rij = $query->fetch()) {
        $hash = ["$rij[Wachtwoord]", "$rij[Voornaam]", "$rij[Achternaam]", "$rij[Adres1]", "$rij[Adres2]", "$rij[Postcode]", "$rij[Plaatsnaam]", "$rij[Land]", "$rij[Geboortedatum]", "$rij[Emailadres]", "$rij[GebruikersID]", "$rij[SoortGebruiker]"];
    }
    $rijtelling = $query->rowCount();

    try {
        if ($rijtelling == 0) {
            throw new Exception($wachtwoordofgebruikersnaamfout);
        } elseif ($rijtelling == 1) {
            if (password_verify($wachtwoord, $hash[0])) {
                $_SESSION['Gebruikersnaam'] = $Gebruikersnaam;
                $_SESSION['Voornaam'] = $hash[1];
                $_SESSION['Achternaam'] = $hash[2];
                $_SESSION['Adres_1'] = $hash[3];
                $_SESSION['Adres_2'] = $hash[4];
                $_SESSION['Postcode'] = $hash[5];
                $_SESSION['Plaatsnaam'] = $hash[6];
                $_SESSION['Land'] = $hash[7];
                $_SESSION['GeboorteDatum'] = $hash[8];
                $_SESSION['Emailadres'] = $hash[9];
                $_SESSION['GebruikersID'] = $hash[10];
                $_SESSION['SoortGebruiker'] = $hash[11];
                $_SESSION['foutmelding'] = "U bent ingelogd";
                if (IsAdmin($Gebruikersnaam)) {
                    header("Location: beheerder/beheerder_homepagina.php");
                    return;
                } else {
                    header("Location: index.php");
                    return;
                }
            } else {
                throw new Exception($wachtwoordofgebruikersnaamfout);
            }
        }
    } catch (Exception $e) {
        $_SESSION['foutmelding'] = $e->getMessage();
        header($locatie);
    }
} else {
    $_SESSION['foutmelding'] = "Er is iets fout gegaan bij het inloggen, probeer het opnieuw";
    header($locatie);
}
