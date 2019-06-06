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



