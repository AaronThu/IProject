<?php

session_start();
include_once 'includes/database.php';
include_once 'includes/functies.php';

$verkopersID = $_GET['VerkoperID'];
$beoordelersID = $_GET['BeoordelerID'];
$feedback = $_GET['feedbackNummer'];


global $dbh;
$feedbackQuery = $dbh->prepare("INSERT INTO Feedback(BeoordelersID,VerkopersID,FeedbackNummer) values (:BeoordelersID, :VerkopersID, :FeedbackNummer)");
$feedbackQuery->execute(
    [
        ':BeoordelersID' => $beoordelersID,
        ':VerkopersID' => $verkopersID,
        ':FeedbackNummer' => $feedback,
    ]
);

function getMailBeoordeler($id)
{
    global $dbh;
    $query = "SELECT Emailadres from gebruiker g inner join Feedback f on g.GebruikersID = f.GebruikersID where f.beoordelersid =  $id";
    $mailGebruikerQuery = $dbh->prepare($query);
    $mailGebruikerQuery->execute();
    $mailGebruiker = $mailGebruikerQuery->fetchall();
    return $mailGebruiker;
}

function getMailVerkoper($id)
{
    global $dbh;
    $query = "SELECT Emailadres from gebruiker g inner join Feedback f on g.GebruikersID = f.GebruikersID where f.verkopersID =  $id";
    $mailGebruikerQuery = $dbh->prepare($query);
    $mailGebruikerQuery->execute();
    $mailGebruiker = $mailGebruikerQuery->fetch();
    return $mailGebruiker;
}

function verstuurFeedbackMail($VerkopersID, $BeoordelersID){
    $locatieNaVersturen = "Location: index.php";

    $to = getMailBeoordeler($BeoordelersID);
    $subject = 'Feedback verkoper';

    $message = '<html lang="nl"><body>';
    $message .= '<p>Bedankt voor uw aankoop! <br> Klik hieronder op een van de links om jouw feedback over de verkoper te geven!</p>';
    $message .= '<p>  --------------------------------------------------------------<br>(Deze link is maar 4 uur geldig)</p>';
    $message .= '<p>Positieve ervaring:</p>';
    $message .= 'http://iproject2.icasites.nl/feedback.php?BeoordelersID=' . $BeoordelersID . '&VerkoperID= ' . $VerkopersID . '&feedbacksoort=5';
    $message .= '<p>Redelijke ervaring:</p>';
    $message .= 'http://iproject2.icasites.nl/feedback.php?BeoordelersID=' . $BeoordelersID . '&VerkoperID= ' . $VerkopersID . '&feedbacksoort=3';
    $message .= '<p>Negatieve ervaring:</p>';
    $message .= 'http://iproject2.icasites.nl/feedback.php?BeoordelersID=' . $BeoordelersID . '&VerkoperID= ' . $VerkopersID . '&feedbacksoort=1';
    $message .= '<p>Bedankt!<br>Team EenmaalAndermaal</p>';
    $message .= "<img src='http://iproject2.icasites.nl/assets/img/EenmaalAndermaal_Logo.png' alt='' width='200' heigth='200' />";
    $message .= 'Om contact op te nemen met de verkoper kunt u hem/haar via ' . getmailVerkoper($VerkopersID) . ' bereiken. ';
    $message .= '</body></html>';

    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From:noreply@EenmaalAndermaal.com' . "\r\n";


    
    // mail($to, $subject, $message, $headers);
    $_SESSION['foutmelding'] = "Mail is succesvol verstuurd, kijk in je inbox voor de links!";
    // header($locatieNaVersturen);
}


verstuurFeedbackMail($verkopersID,$beoordelersID);