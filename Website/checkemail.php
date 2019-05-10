<?php
session_start();
include_once('database.php');
include_once('functies.php');

$tijdLinkGeldig = 14400;
$locatieFouteLink = "Location: http://iproject2.icasites.nl/registreren_emailpagina.php";


if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {
    $masterPW = "test";
    $meegevenHash = $_GET['hash'];
    $email = test_invoer($_GET['email']);
    $gegevenTijd = $_GET['tijd'];
    $hash = hash('sha256', $email . $masterPW);
    if($hash == $meegevenHash && time() - $gegevenTijd < $tijdLinkGeldig){
        $_SESSION['Emailadres'] = $email;
        header("Location: http://iproject2.icasites.nl/registreren_pagina.php");
    } elseif(time() - $gegevenTijd > $tijdLinkGeldig){
        $_SESSION['foutmelding'] = "Deze link is niet meer geldig, laat een nieuwe mail naar je versturen";
        header($locatieFouteLink);
    } elseif(vergelijkloginwaarde("Emailadres", $_GET['email'], $dbh) != 0){
        $_SESSION['foutmelding'] = "Dit mailadres is al geregistreerd, vul een ander mailadres in";
        header($locatieFouteLink);
    }   else{
        $_SESSION['foutmelding'] = "De opgegeven link is invalide, gebruik de link die is opgestuurd";
        header($locatieFouteLink);
    }
} else{
    $_SESSION['foutmelding'] = "Dit is geen valide adres, gebruik de link die is opgestuurd";
    header($locatieFouteLink);
}

?>