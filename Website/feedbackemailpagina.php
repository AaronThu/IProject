<?php
session_start();

include_once "includes/database.php";

$locatieNaVersturen = "Location: index.php";
$MailGegevens = GetMailAdres();

if (!isset($MailGegevens[0]['Emailadres'])) {
    echo 'Er zijn geen mails om te versturen.';
    return;
}

foreach ($MailGegevens as $key => $value) {
    $to = $value['Emailadres'];
    $subject = 'Bieding gewonnen | Feedback verkoper';
    $fotoLocatie = 'http://iproject2.icasites.nl/assets/img/';

    $message = '<html lang="nl"><body>';
    $message .= '<p>Gefeliciteerd met het winnen van de veiling! <br> Klik hieronder op een van de links om jouw feedback over de verkoper te geven!</p>';
    $message .= '<p>  --------------------------------------------------------------<br>(Deze link is maar 4 uur geldig)</p>';
    $message .= '<p>Positieve ervaring:</p>';
    $message .= '<a href=http://iproject2.icasites.nl/feedback.php?feedback=5&VerkopersID=' . $value['VerkopersID'] . '&BeoordelersID=' . $value['KopersID'] . '><img src=' . $fotoLocatie . '5star.jpg alt="5 sterren" width="100" height="20"></a>';
    $message .= '<p>Redelijke ervaring:</p>';
    $message .= '<a href=http://iproject2.icasites.nl/feedback.php?feedback=5&VerkopersID=' . $value['VerkopersID'] . '&BeoordelersID=' . $value['KopersID'] . '><img src=' . $fotoLocatie . '3star.jpg alt="5 sterren" width="100" height="20"></a>';
    $message .= '<p>Negatieve ervaring:</p>';
    $message .= '<a href=http://iproject2.icasites.nl/feedback.php?feedback=5&VerkopersID=' . $value['VerkopersID'] . '&BeoordelersID=' . $value['KopersID'] . '><img src=' . $fotoLocatie . '1star.jpg alt="5 sterren" width="100" height="20"></a>';
    $message .= '<p>Bedankt!<br>Team EenmaalAndermaal</p>';
    $message .= '<img src=http://iproject2.icasites.nl/assets/img/EenmaalAndermaal_Logo.png alt=EenmaalAndermaal Logo width=200 heigth=200/>';
    $message .= 'Om contact op te nemen met de verkoper kunt u hem/haar via ' . $to . ' bereiken. ';
    $message .= '</body></html>';

    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From:noreply@EenmaalAndermaal.com' . "\r\n";

    mail($to, $subject, $message, $headers);
    echo 'Mail is succesvol verstuurd aan ' . $value['Emailadres'];

    $query = $dbh->prepare("UPDATE Voorwerp SET MailVerstuurd = 1 WHERE Voorwerpnummer = :Voorwerpnummer");
    $query->execute(
    [
        ':Voorwerpnummer' => $value['Voorwerpnummer'],
    ]
    );
}

function GetMailAdres()
{
    global $dbh;
    $query = $dbh->prepare("SELECT g.Emailadres, v.VerkopersID, v.KopersID, v.Voorwerpnummer FROM Gebruiker g INNER JOIN Voorwerp v ON g.GebruikersID = v.KopersID WHERE v.VeilingGesloten = 1 AND MailVerstuurd = 0;");   
    $query->execute();
    $mailAdres = $query->fetchAll();
    return $mailAdres;
}
?>