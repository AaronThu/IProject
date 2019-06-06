<?php
session_start();

include_once "includes/database.php";

$locatieNaVersturen = "Location: index.php";

$to = GetMailAdres()['Emailadres'];
$subject = 'Feedback verkoper';

$message = '<html lang="nl"><body>';
$message .= '<p>Gefeliciteerd met het winnen van de veiling! <br> Klik hieronder op een van de links om jouw feedback over de verkoper te geven!</p>';
$message .= '<p>  --------------------------------------------------------------<br>(Deze link is maar 4 uur geldig)</p>';
$message .= '<p>Positieve ervaring:</p>';
$message .= 'http://iproject2.icasites.nl/feedback.php?feedback=5&VerkoperID=2106&BeoordelerID=2107';
$message .= '<p>Redelijke ervaring:</p>';
$message .= 'http://iproject2.icasites.nl/feedback.php?feedback=3&VerkoperID=2106&BeoordelerID=2107';
$message .= '<p>Negatieve ervaring:</p>';
$message .= 'http://iproject2.icasites.nl/feedback.php?feedback=1&VerkoperID=2106&BeoordelerID=2107';
$message .= '<p>Bedankt!<br>Team EenmaalAndermaal</p>';
$message .= "<img src='http://iproject2.icasites.nl/assets/img/EenmaalAndermaal_Logo.png' alt='' width='200' heigth='200' />";
$message .= 'Om contact op te nemen met de verkoper kunt u hem/haar via ' . $to . ' bereiken. ';
$message .= '</body></html>';

$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From:noreply@EenmaalAndermaal.com' . "\r\n";

mail($to, $subject, $message, $headers);
// $_SESSION['foutmelding'] = "Mail is succesvol verstuurd, kijk in je inbox voor de links!";
header($locatieNaVersturen);

function getMailAdres()
{
    global $dbh;
    $query = $dbh->prepare("SELECT Emailadres FROM Gebruiker WHERE Gebruikersnaam = 'tymo'");   
    $query->execute();
    $mailAdres = $query->fetch();
    return $mailAdres;
}
?>