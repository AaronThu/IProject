<?php
include_once ('functies.php');
session_start();

$mailadres = $_SESSION['Emailadres'];
//$mailadres = "jossenobel@hotmail.com";
$masterPW = "test";
$time = hash('sha256', time());
$hash = hash('sha256', $mailadres . $masterPW);


$to      = $mailadres;
$subject = 'Registreren | Verificatie';
$message = '
 
Bedankt voor het registreren!
Klik hieronder op de link om jouw mailadres te verifieren en om de registratie te kunnen voortzetten:

 --------------------------------------------------------------
 
http://iproject2.icasites.nl/registreren_pagina.php?email='. $mailadres .'&hash='.$hash. '&tijd='. $time;

$headers = 'From:noreply@EenmaalAndermaal.com' . "\r\n";
mail($to, $subject, $message, $headers);
