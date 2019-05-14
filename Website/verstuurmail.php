<?php
include_once('functies.php');
session_start();
$locatieNaVersturen = "Location: http://iproject2.icasites.nl/index.php";

$mailadres = $_SESSION['Emailadres'];
$masterPW = "test";
$hash = hash('sha256', $mailadres . $masterPW);

$add = $mailadres . '&hash=' . $hash . '&tijd=' . time();
$to = $mailadres;
$subject = 'Registreren | Verificatie';
$message = '<html lang="nl"><body>';
$message .= '<p>Hello, <br> hier onder staat je link!</p>';
$message .='http://iproject2.icasites.nl/checkemail.php?email='. $mailadres .'&hash='.$hash. '&tijd='. time();
$message .= '</body></html>';


$headers = 'From:noreply@EenmaalAndermaal.com' . "\r\n";
$headers = 'MIME-Version:1.0' . "\r\n";
mail($to, $subject, $message, $headers);


$_SESSION['foutmelding'] = "Mail is succesvol verstuurd, kijk in je inbox voor de link!";
header($locatieNaVersturen);
?>



