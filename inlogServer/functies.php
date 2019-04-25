<?php

function test_invoer($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
};

function vergelijkloginwaarde($vergelijken, $waarde, $dbh){
    $vergelijkloginnaam = $dbh->prepare("SELECT Gebruikersnaam, Voornaam, Achternaam, Adres_1, Adres_2, Postcode, Plaatsnaam, Land, GeboorteDatum, Emailadres FROM gebruiker WHERE $vergelijken = :waarde");
    $vergelijkloginnaam->execute([':waarde' => $waarde]);
    $telling = $vergelijkloginnaam->rowCount();
    return $telling;
}

function kijkVoorLetters($string){
    return preg_match( '/[a-zA-Z]/', $string );
}

function kijkVoorCijfers($string){
    return preg_match( '/\d/', $string );
}

function genereerVraagNummer($dbh){
    $totaalAantalVragen = $dbh->query("SELECT * FROM Vraag");
    $rijtelling = $totaalAantalVragen->fetch();
    $nummer = mt_rand(1, count($rijtelling)-1);
    return $nummer;
}

function genereerVraag($dbh, $vraagnummer)
{
    $registratievraag = $dbh->query("SELECT Vraag FROM Vraag WHERE Vraagnummer = $vraagnummer");
    $vraagWeergave = "";
    while ($vraag = $registratievraag->fetch()) {
        $vraagWeergave .= "<p>Vul een antwoord in op de volgende vraag: $vraag[Vraag]</p>";
    }
    return $vraagWeergave;
}
