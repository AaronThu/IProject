<?php
session_start();

include_once 'includes/database.php';
include_once "includes/functies.php";

if (!isset($_GET["feedback"])) {
    return;
}
if (!isset($_GET["VerkopersID"])) {
    return;
}
if (!isset($_GET["BeoordelersID"])) {
    return;
}

$feedback = test_invoer($_GET["feedback"]);
if (!is_numeric($feedback)) {
    return;
}
$verkopersID = test_invoer($_GET["VerkopersID"]);
if (!is_numeric($verkopersID)) {
    return;
}
$beoordelersID = test_invoer($_GET["BeoordelersID"]);
if (!is_numeric($beoordelersID)) {
    return;
}

$locatieNaFeedback = "Location: index.php";

$query = $dbh->prepare("INSERT Feedback (BeoordelersID, VerkopersID, FeedbackNummer) VALUES (:BeoordelersID, :VerkopersID, :FeedbackNummer)");
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