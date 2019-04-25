<?php
session_Start();
include_once('database.php');
if (isset($_SESSION['Gebruikersnaam'])) {
    $inloggen = '<form method="post" class="zoekbalk" action="inlogsysteem.php">  
<input type="submit" name="uitloggen" Value="Uitloggen"> </form>' .
        "<p>Voornaam: " . $_SESSION['Voornaam'] . "</p>
<p>Achternaam: " . $_SESSION['Achternaam'] . "</p>
<p>Emailadres: " . $_SESSION['Emailadres'] . "</p>
<p>Adres_1: " . $_SESSION['Adres_1'] . "</p>
<p>Adres_2: " . $_SESSION['Adres_2'] . "</p>
<p>Postcode: " . $_SESSION['Postcode'] . "</p>
<p>Plaastnaam: " . $_SESSION['Plaatsnaam'] . "</p>
<p>Land: " . $_SESSION['Land'] . "</p>
<p>GeboorteDatum: " . $_SESSION['GeboorteDatum'] . "</p>";
    
} else {
$inloggen ='<form method="post" class="zoekbalk" action="inlogsysteem.php">
        <label for="Username"></label>
        <input type="text" name="Gebruikersnaam" id="Gebruikersnaam" placeholder="Gebruikersnaam" required>
        <label for="wachtwoord"></label>
        <input type="password" name="wachtwoord" id="wachtwoord" placeholder="Wachtwoord" required>
        <input type="submit" name="inloggen" Value="Inloggen">
    </form>';
}

if (isset($_SESSION['foutmelding'])) {
    echo $_SESSION['foutmelding'];
    $_SESSION['foutmelding'] = "";
}

?>

<p><?php echo $inloggen; ?></p>