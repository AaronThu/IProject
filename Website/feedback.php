<?php

session_start();
include_once 'includes/database.php';

$locatieNaFeedback = "Location: index.php";
$verkopersID = $_GET['VerkoperID'];
$beoordelersID = $_GET['BeoordelerID'];
$feedback = $_GET['feedback'];

$query = $dbh->prepare("INSERT INTO Feedback (BeoordelersID, VerkopersID, FeedbackNummer) VALUES (:BeoordelersID, :VerkopersID, :FeedbackNummer)");
$query->execute(
    [
        ':BeoordelersID' => $beoordelersID,
        ':VerkopersID' => $verkopersID,
        ':FeedbackNummer' => $feedback,
    ]
);

$_SESSION['foutmelding'] = "Bedankt voor uw feedback!";
header($locatieNaFeedback);
?>