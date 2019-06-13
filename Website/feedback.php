<?php
session_start();

include_once 'includes/database.php';
include_once "includes/functies.php";

// Kijkt of GET een waarde bevat
if (!isset($_GET["feedback"])) {
    return;
}
if (!isset($_GET["VerkopersID"])) {
    return;
}
if (!isset($_GET["BeoordelersID"])) {
    return;
}

// Test of GET numeriek is en vult variabele
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

// Insert feedback in de database
$query = $dbh->prepare("INSERT Feedback (BeoordelersID, VerkopersID, FeedbackNummer) VALUES (:BeoordelersID, :VerkopersID, :FeedbackNummer)");
$query->execute(
    [
        ':BeoordelersID' => $beoordelersID,
        ':VerkopersID' => $verkopersID,
        ':FeedbackNummer' => $feedback,
    ]
);

// Doorsturen naar homepagina
$_SESSION['foutmelding'] = "Bedankt voor uw feedback!";
header($locatieNaFeedback);
?>