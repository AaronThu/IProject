<?php
include_once "includes/functies.php";
session_start();
$locatieNaVersturen = "Location: index.php";

$mailadres = $_SESSION['Emailadres'];
$masterPW = "test";
$hash = hash('sha256', $mailadres . $masterPW);

$add = $mailadres . '&hash=' . $hash . '&tijd=' . time();
$to = $mailadres;
$subject = 'Registreren | Verificatie';

$message = '<html lang="nl"><body>';
$message .= '<p>Bedankt voor het registreren! <br> Klik hieronder op de link om jouw mailadres te verifiëren en de registratie voort te zetten:</p>';
$message .= '<p>  --------------------------------------------------------------<br>(Deze link is maar 4 uur geldig)</p>';
$message .= 'http://iproject2.icasites.nl/checkemail.php?email=' . $mailadres . '&hash=' . $hash . '&tijd=' . time();
$message .= '<p>Bedankt!<br>Team EenmaalAndermaal</p>';
$message .= "<img src='http://iproject2.icasites.nl/assets/img/EenmaalAndermaal_Logo.png' alt='' width='200' heigth='200' />";
$message .= '</body></html>';

$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From:noreply@EenmaalAndermaal.com' . "\r\n";

mail($to, $subject, $message, $headers);

$_SESSION['foutmelding'] = "Mail is succesvol verstuurd, kijk in je inbox voor de link!";
header($locatieNaVersturen);
?>



