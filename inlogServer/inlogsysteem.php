<?php
session_Start();
include_once ('database.php');
include_once ('functies.php');
$locatie = "Location: http://localhost/inlogServer/inlogScherm.php";
if(isset($_POST['inloggen'])){
    if(!isset($_SESSION['Gebruikersnaam'])){
        $Gebruikersnaam = test_invoer($_POST['Gebruikersnaam']);
        $wachtwoord = test_invoer($_POST['wachtwoord']);
        $wachtwoordofgebruikersnaamfout = "Het wachtwoord of de gebruikersnaam is fout, probeer het opnieuw";
        $query = $dbh->prepare("SELECT Wachtwoord, Voornaam, Achternaam, Adres_1, Adres_2, Postcode, Plaatsnaam, Land, GeboorteDatum, Emailadres FROM Gebruiker WHERE Gebruikersnaam = :Gebruikersnaam");
        $query->execute([':Gebruikersnaam' => $Gebruikersnaam]);
        $hash = [];

        while ($rij = $query->fetch()) {
            $hash = ["$rij[Wachtwoord]", "$rij[Voornaam]", "$rij[Achternaam]", "$rij[Adres_1]", "$rij[Adres_2]", "$rij[Postcode]", "$rij[Plaatsnaam]", "$rij[Land]", "$rij[GeboorteDatum]", "$rij[Emailadres]"];
        }
        $rijtelling = $query->rowCount();

        try {
            if ($rijtelling == 0) {
                throw new Exception($wachtwoordofgebruikersnaamfout);
                header("$locatie");
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
                    throw new Exception("U bent ingelogd");
                    header("$locatie");
                } else {
                    throw new Exception($wachtwoordofgebruikersnaamfout);
                    header("$locatie");
                }
            }
        } catch (Exception $e) {
            $_SESSION['foutmelding'] = $e->getMessage();
            header("Location: http://localhost/inlogServer/inlogScherm.php");
        }
    }
} elseif (isset($_POST['uitloggen'])) {
    session_destroy();
    session_start();
    $_SESSION['foutmelding'] = "U bent uitgelogd";
    header("$locatie");
} else {
    $_SESSION['foutmelding'] = "Er is iets fout gegaan bij het inloggen, probeer het opnieuw";
    header("$locatie");
}