<?php
include_once ('functies.php');
session_start();
$locatieNaVersturen = "Location: http://iproject2.icasites.nl/index.php";

$mailadres = $_SESSION['Emailadres'];
$masterPW = "test";
$hash = hash('sha256', $mailadres . $masterPW);

$add =  $mailadres .'&hash='.$hash. '&tijd='. time();
$to      = $mailadres;
$subject = 'Registreren | Verificatie';
$message = "
 
hoi,
Bedankt voor het registreren!
Klik hieronder op de link om jouw mailadres te verifieren en om de registratie te kunnen voortzetten:

 --------------------------------------------------------------
 
 
http://iproject2.icasites.nl/checkemail.php?email=$add".

'alvast bedankt
EenmaalAndermaal team';

$headers = 'From:noreply@EenmaalAndermaal.com' . "\r\n";
mail($to, $subject, $message, $headers);



$_SESSION['foutmelding'] = "Mail is succesvol verstuurd, kijk in je inbox voor de link!";
header($locatieNaVersturen);
?>