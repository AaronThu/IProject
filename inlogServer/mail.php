<?php
include_once ('functies.php');
session_start();

//$mailadres = $_SESSION['Emailadres'];
$mailadres = "jossenobel@hotmail.com";
$masterPW = "test";
$hash = hash('md5', $mailadres . $masterPW);


$to      = $mailadres;
$subject = 'Registreren | Verificatie';
$message = '
 
Bedankt voor het registreren!
Klik hieronder op de link om jouw mailadres te verifieren en om de registratie te kunnen voortzetten:

 --------------------------------------------------------------
http://localhost/inlogServer/registratiesysteem.php?email='. $mailadres .'&hash='.$hash. '&tijd='. time();

$headers = 'From:noreply@EenmaalAndermaal.com' . "\r\n";
mail($to, $subject, $message, $headers);