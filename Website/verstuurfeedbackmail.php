<?php 
include_once 'includes/functies.php';
session_start();
$locatienaVersturen= "Location: index.php";

$mailadres = $_SESSION['Emailadres'];


$add = $mailadres;
$to = $mailadres;
$subject = 'Feedback verkoper';

$message = '<html lang="nl"><body>';
$message .= '<p>Bedankt voor uw aankoop! <br> Klik hieronder op een van de links om jouw feedback over de verkoper te geven!</p>';
$message .= '<p>  --------------------------------------------------------------<br>(Deze link is maar 4 uur geldig)</p>';
$message .= '<p>Positieve ervaring:</p>';
$message .= 'http://iproject2.icasites.nl/feedback?gebruikerID=' . $gebruikersID . '&feedbacksoort=5';
$message .= '<p>Redelijke ervaring:</p>';
$message .= 'http://iproject2.icasites.nl/feedback?gebruikerID=' . $gebruikersID . '&feedbacksoort=3';
$message .= '<p>Negatieve ervaring:</p>';
$message .= 'http://iproject2.icasites.nl/feedback?gebruikerID=' . $gebruikersID . '&feedbacksoort=1';
$message .= '<p>Bedankt!<br>Team EenmaalAndermaal</p>';
$message .= "<img src='http://iproject2.icasites.nl/assets/img/EenmaalAndermaal_Logo.png' alt='' width='200' heigth='200' />";
$message .= '</body></html>';

$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From:noreply@EenmaalAndermaal.com' . "\r\n";

mail($to, $subject,$message,$headers);
?>

